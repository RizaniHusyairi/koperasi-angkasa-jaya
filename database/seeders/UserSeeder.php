<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Pegawai;
use App\Models\Tabungan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@koperasi.aptpairport.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->assignRole('super-admin');

        // Create Staff Keuangan Role if not exists
        // This is usually done in RoleSeeder, but for simplicity/completeness ensuring it here or in migration
        // $role = Role::firstOrCreate(['name' => 'staff-keuangan']); 

        // Create SPV
        $spv = User::firstOrCreate(
            ['email' => 'spv@koperasi.aptpairport.id'],
            [
                'name' => 'Supervisor',
                'password' => Hash::make('password'),
            ]
        );
        $spv->assignRole('spv');

        // Create Admin Simpan Pinjam
        $adminSP = User::firstOrCreate(
            ['email' => 'adminsp@koperasi.aptpairport.id'],
            [
                'name' => 'Admin Simpan Pinjam',
                'password' => Hash::make('password'),
            ]
        );
        $adminSP->assignRole('admin-simpan-pinjam');

        // Create Admin Mini Market
        $adminMiniMarket = User::firstOrCreate(
            ['email' => 'adminmarket@koperasi.aptpairport.id'],
            [
                'name' => 'Admin Mini Market',
                'password' => Hash::make('password'),
            ]
        );
        $adminMiniMarket->assignRole('admin-mini-market');

        // Create Pegawai Staff Keuangan 1
        $staff1 = User::firstOrCreate(
            ['email' => 'staff1@koperasi.aptpairport.id'],
            [
                'name' => 'Staff Keuangan 1',
                'password' => Hash::make('password'),
            ]
        );
        $staff1->assignRole('staff-keuangan');
        
        Pegawai::firstOrCreate(
            ['user_id' => $staff1->id],
            [
                'nik' => 'PEG-001',
                'nama_lengkap' => 'Staff Keuangan 1',
                'jabatan' => 'Staff Keuangan',
                'unit_kerja' => 'Keuangan',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Koperasi No. 1',
            ]
        );

        // Create Pegawai Staff Keuangan 2
        $staff2 = User::firstOrCreate(
            ['email' => 'staff2@koperasi.aptpairport.id'],
            [
                'name' => 'Staff Keuangan 2',
                'password' => Hash::make('password'),
            ]
        );
        $staff2->assignRole('staff-keuangan');

        Pegawai::firstOrCreate(
            ['user_id' => $staff2->id],
            [
                'nik' => 'PEG-002',
                'nama_lengkap' => 'Staff Keuangan 2',
                'jabatan' => 'Staff Keuangan',
                'unit_kerja' => 'Keuangan',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Koperasi No. 2',
            ]
        );

        // Create Anggota Demo
        
    }
}
