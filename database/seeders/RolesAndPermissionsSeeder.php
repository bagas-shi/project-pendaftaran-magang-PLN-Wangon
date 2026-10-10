<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeder: RolesAndPermissionsSeeder
 *
 * Creates the three core roles and assigns default permissions.
 * Also creates a default super_admin account for initial access.
 *
 * Run: php artisan db:seed --class=RolesAndPermissionsSeeder
 */
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ──────────────────────────────────────────────
        // Create Permissions
        // ──────────────────────────────────────────────

        $permissions = [
            // Peserta permissions
            'pendaftaran.create',
            'pendaftaran.view-own',
            'berkas.upload',
            'berkas.download-own',
            'surat.download',

            // Admin permissions
            'pendaftaran.view-all',
            'pendaftaran.verify',
            'pendaftaran.approve',
            'pendaftaran.reject',
            'berkas.download-all',
            'export.excel',
            'export.pdf',

            // Super Admin permissions
            'admin.manage',
            'system.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ──────────────────────────────────────────────
        // Create Roles & Assign Permissions
        // ──────────────────────────────────────────────

        // Peserta (Candidate)
        $peserta = Role::firstOrCreate(['name' => 'peserta']);
        $peserta->syncPermissions([
            'pendaftaran.create',
            'pendaftaran.view-own',
            'berkas.upload',
            'berkas.download-own',
            'surat.download',
        ]);

        // Admin (PLN Staff)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'pendaftaran.view-all',
            'pendaftaran.verify',
            'pendaftaran.approve',
            'pendaftaran.reject',
            'berkas.download-all',
            'export.excel',
            'export.pdf',
        ]);

        // Super Admin (System Manager)
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(Permission::all());

        // ──────────────────────────────────────────────
        // Create Default Super Admin Account
        // ──────────────────────────────────────────────

        $defaultAdmin = User::firstOrCreate(
            ['email' => 'superadmin@pln-wangon.co.id'],
            [
                'name'              => 'Super Administrator',
                'password'          => 'password123', // Change in production!
                'email_verified_at' => now(),
            ]
        );

        if (! $defaultAdmin->hasRole('super_admin')) {
            $defaultAdmin->assignRole('super_admin');
        }

        // Create Default Admin Account (Staff PLN)
        $staffAdmin = User::firstOrCreate(
            ['email' => 'admin@pln-wangon.co.id'],
            [
                'name'              => 'Admin PLN Wangon',
                'password'          => 'password123',
                'email_verified_at' => now(),
            ]
        );

        if (! $staffAdmin->hasRole('admin')) {
            $staffAdmin->assignRole('admin');
        }

        $this->command->info('✅ Roles, permissions, default super admin, and admin created successfully.');
        $this->command->info('   Super Admin : superadmin@pln-wangon.co.id / password123');
        $this->command->info('   Admin Staff : admin@pln-wangon.co.id / password123');
    }
}
