<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

/**
 * Controller: SuperAdminController
 *
 * Full system management accessible only to super_admin:
 * - Dashboard with system-wide statistics
 * - Manage admin users (create, edit, delete)
 * - View all system roles
 */
class SuperAdminController extends Controller
{
    /**
     * Super admin dashboard with system overview.
     */
    public function dashboard(): View
    {
        $stats = [
            'total_users'   => User::count(),
            'total_peserta' => User::role('peserta')->count(),
            'total_admin'   => User::role('admin')->count(),
            'total_roles'   => Role::count(),
        ];

        return view('superadmin.dashboard', compact('stats'));
    }

    /**
     * List all admin users.
     */
    public function adminIndex(): View
    {
        $admins = User::role(['admin', 'super_admin'])
            ->orderBy('name')
            ->paginate(15);

        return view('superadmin.admins.index', compact('admins'));
    }

    /**
     * Show form to create a new admin user.
     */
    public function adminCreate(): View
    {
        return view('superadmin.admins.create');
    }

    /**
     * Store a new admin user.
     */
    public function adminStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', 'in:admin,super_admin'],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->assignRole($validated['role']);

        Log::info('Admin user created', [
            'created_by' => auth()->id(),
            'new_user'   => $user->id,
            'role'        => $validated['role'],
        ]);

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', "Admin {$user->name} berhasil dibuat.");
    }

    /**
     * Delete an admin user.
     */
    public function adminDestroy(User $user): RedirectResponse
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->withErrors(['delete' => 'Anda tidak dapat menghapus akun sendiri.']);
        }

        $userName = $user->name;
        $user->delete();

        Log::info('Admin user deleted', [
            'deleted_by' => auth()->id(),
            'deleted_user' => $userName,
        ]);

        return redirect()
            ->route('superadmin.admins.index')
            ->with('success', "Admin {$userName} berhasil dihapus.");
    }
}
