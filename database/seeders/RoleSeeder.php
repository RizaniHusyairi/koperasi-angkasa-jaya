<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $anggota = Role::firstOrCreate(['name' => 'anggota']);
        $spv = Role::firstOrCreate(['name' => 'spv']);
        $adminSimpanPinjam = Role::firstOrCreate(['name' => 'admin-simpan-pinjam']);
        $adminMiniMarket = Role::firstOrCreate(['name' => 'admin-mini-market']);

        // Create permissions
        // User management permissions
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);

        // Anggota management permissions
        Permission::firstOrCreate(['name' => 'view anggota']);
        Permission::firstOrCreate(['name' => 'create anggota']);
        Permission::firstOrCreate(['name' => 'edit anggota']);
        Permission::firstOrCreate(['name' => 'delete anggota']);

        // Simpanan permissions
        Permission::firstOrCreate(['name' => 'view simpanan']);
        Permission::firstOrCreate(['name' => 'manage simpanan']);

        // Pinjaman permissions
        Permission::firstOrCreate(['name' => 'view pinjaman']);
        Permission::firstOrCreate(['name' => 'manage pinjaman']);

        // Pengajuan permissions
        Permission::firstOrCreate(['name' => 'create pengajuan']);
        Permission::firstOrCreate(['name' => 'view pengajuan']);
        Permission::firstOrCreate(['name' => 'approve pengajuan']);

        // Pegawai permissions
        Permission::firstOrCreate(['name' => 'view pegawai']);
        Permission::firstOrCreate(['name' => 'create pegawai']);
        Permission::firstOrCreate(['name' => 'edit pegawai']);
        Permission::firstOrCreate(['name' => 'delete pegawai']);

        // Mini Market permissions
        Permission::firstOrCreate(['name' => 'manage products']);
        Permission::firstOrCreate(['name' => 'manage orders']);
        Permission::firstOrCreate(['name' => 'view orders']);

        // Assign permissions to roles
        $superAdmin->givePermissionTo(Permission::all());

        $anggota->givePermissionTo([
            'view simpanan',
            'view pinjaman',
            'create pengajuan',
            'view pengajuan',
        ]);

        $spv->givePermissionTo([
            'view pegawai',
            'create pegawai',
            'edit pegawai',
            'delete pegawai',
        ]);

        $adminSimpanPinjam->givePermissionTo([
            'view anggota',
            'view simpanan',
            'manage simpanan',
            'view pinjaman',
            'manage pinjaman',
            'view pengajuan',
            'approve pengajuan',
        ]);

        $adminMiniMarket->givePermissionTo([
            'manage products',
            'manage orders',
            'view orders',
            'view anggota',
        ]);
    }
}
