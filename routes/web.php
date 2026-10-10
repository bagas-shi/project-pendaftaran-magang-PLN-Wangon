<?php

use App\Http\Controllers\AdminSelectionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Sistem Pendaftaran Magang PLN ULP Wangon
|--------------------------------------------------------------------------
|
| Route groups organized by authentication & role:
| 1. Public routes (guest)
| 2. Authenticated routes (any logged-in user)
| 3. Peserta routes (candidates)
| 4. Admin routes (PLN staff)
| 5. Super Admin routes (system managers)
|
*/

// ──────────────────────────────────────────────────────
// 1. Public / Guest Routes
// ──────────────────────────────────────────────────────

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes (accessible only to guests)
Route::middleware('guest')->group(function () {
    // Registration
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Google OAuth
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

// ──────────────────────────────────────────────────────
// 2. Authenticated Routes (Shared — Any Role)
// ──────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Generic Dashboard Redirect (handles default Laravel redirects)
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('super_admin')) return redirect()->route('superadmin.dashboard');
        if ($user->hasRole('admin')) return redirect()->route('admin.dashboard');
        return redirect()->route('peserta.dashboard');
    })->name('dashboard');

    // Secure file download (owner or admin can access)
    Route::get('/berkas/{berkas}/download', [PendaftaranController::class, 'downloadBerkas'])
        ->name('berkas.download');
});

// ──────────────────────────────────────────────────────
// 3. Peserta (Candidate) Routes
// ──────────────────────────────────────────────────────

Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PendaftaranController::class, 'dashboard'])->name('dashboard');

    // Application management
    Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');

});

// ──────────────────────────────────────────────────────
// 4. Admin Routes
// ──────────────────────────────────────────────────────

Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminSelectionController::class, 'dashboard'])->name('dashboard');

    // Application management
    Route::get('/pendaftaran', [AdminSelectionController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{pendaftaran}', [AdminSelectionController::class, 'show'])->name('pendaftaran.show');

    // Verification & approval actions
    Route::patch('/pendaftaran/{pendaftaran}/verify', [AdminSelectionController::class, 'verify'])->name('pendaftaran.verify');
    Route::patch('/pendaftaran/{pendaftaran}/approve', [AdminSelectionController::class, 'approve'])->name('pendaftaran.approve');
    Route::patch('/pendaftaran/{pendaftaran}/reject', [AdminSelectionController::class, 'reject'])->name('pendaftaran.reject');

    // Data Export
    Route::get('/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
});

// ──────────────────────────────────────────────────────
// 5. Super Admin Routes
// ──────────────────────────────────────────────────────

Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // Admin user management
    Route::get('/admins', [SuperAdminController::class, 'adminIndex'])->name('admins.index');
    Route::get('/admins/create', [SuperAdminController::class, 'adminCreate'])->name('admins.create');
    Route::post('/admins', [SuperAdminController::class, 'adminStore'])->name('admins.store');
    Route::delete('/admins/{user}', [SuperAdminController::class, 'adminDestroy'])->name('admins.destroy');
});
