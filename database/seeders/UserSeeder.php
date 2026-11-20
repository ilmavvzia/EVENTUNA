<?php

namespace Database\Seeders;

use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Super Admin (Kemahasiswaan)
        User::firstOrCreate(
            ['email' => 'admin@eventuna.ac.id'],
            [
                'name' => 'Admin Kemahasiswaan UNAIR',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status_akun' => 'verified',
            ]
        );

        $fv = MasterFakultas::where('kode_fakultas', 'FV')->first();
        $hima = MasterJenisOrmawa::where('nama_jenis', 'HIMA')->first();
        $bem = MasterJenisOrmawa::where('nama_jenis', 'BEM')->first();

        // 2. Akun Ormawa 1 (HIMTI Vokasi)
        User::firstOrCreate(
            ['email' => 'himti@vokasi.unair.ac.id'],
            [
                'name' => 'HIMTI D4 Teknik Informatika',
                'password' => Hash::make('password123'),
                'role' => 'ormawa',
                'status_akun' => 'verified',
                'fakultas_id' => $fv?->id,
                'jenis_ormawa_id' => $hima?->id,
                'deskripsi_singkat' => 'Himpunan Mahasiswa Program Studi D4 Teknik Informatika Fakultas Vokasi Universitas Airlangga.',
            ]
        );

        // 3. Akun Ormawa 2 (BEM Vokasi)
        User::firstOrCreate(
            ['email' => 'bem@vokasi.unair.ac.id'],
            [
                'name' => 'BEM Fakultas Vokasi',
                'password' => Hash::make('password123'),
                'role' => 'ormawa',
                'status_akun' => 'verified',
                'fakultas_id' => $fv?->id,
                'jenis_ormawa_id' => $bem?->id,
                'deskripsi_singkat' => 'Badan Eksekutif Mahasiswa Fakultas Vokasi Universitas Airlangga.',
            ]
        );
    }
}