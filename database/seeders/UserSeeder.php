<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
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
        // Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@koperasi.aptpairport.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->assignRole('super-admin');

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

        // Create Anggota Demo
        
    }
}
