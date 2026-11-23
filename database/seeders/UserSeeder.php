<?php

namespace Database\Seeders;

use App\Models\MasterBenefitSkp;
use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use App\Models\MasterKategoriEvent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles (RBAC)
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Super Admin Kemahasiswaan']
        );

        $ormawaRole = Role::firstOrCreate(
            ['name' => 'ormawa'],
            ['label' => 'Pengurus Ormawa']
        );

        // 2. Data Referensi Fakultas
        $fv = MasterFakultas::firstOrCreate(
            ['kode_fakultas' => 'FV'],
            ['nama_fakultas' => 'Fakultas Vokasi']
        );
        MasterFakultas::firstOrCreate(
            ['kode_fakultas' => 'FST'],
            ['nama_fakultas' => 'Fakultas Sains dan Teknologi']
        );
        MasterFakultas::firstOrCreate(
            ['kode_fakultas' => 'FEB'],
            ['nama_fakultas' => 'Fakultas Ekonomi dan Bisnis']
        );

        // 3. Data Referensi Jenis Ormawa
        $hima = MasterJenisOrmawa::firstOrCreate(
            ['nama_jenis' => 'HIMA'],
            ['deskripsi' => 'Himpunan Mahasiswa Program Studi / Departemen']
        );
        MasterJenisOrmawa::firstOrCreate(
            ['nama_jenis' => 'BEM'],
            ['deskripsi' => 'Badan Eksekutif Mahasiswa']
        );
        MasterJenisOrmawa::firstOrCreate(
            ['nama_jenis' => 'UKM'],
            ['deskripsi' => 'Unit Kegiatan Mahasiswa']
        );

        // 4. Demo Akun Super Admin
        User::updateOrCreate(
            ['email' => 'admin@eventuna.ac.id'],
            [
                'name'        => 'Super Admin Kemahasiswaan',
                'password'    => Hash::make('password123'),
                'role_id'     => $adminRole->id,
                'status_akun' => 'verified',
            ]
        );

        // 5. Demo Akun Ormawa (HIMTI D4 Teknik Informatika)
        User::updateOrCreate(
            ['email' => 'himti@vokasi.unair.ac.id'],
            [
                'name'              => 'HIMTI D4 Teknik Informatika',
                'password'          => Hash::make('password123'),
                'role_id'           => $ormawaRole->id,
                'status_akun'       => 'verified',
                'fakultas_id'       => $fv->id,
                'jenis_ormawa_id'   => $hima->id,
                'deskripsi_singkat' => 'Himpunan Mahasiswa D4 Teknik Informatika Fakultas Vokasi Universitas Airlangga.',
            ]
        );

        // 6. Data Referensi Master Kategori Event (M1)
        $kategoris = [
            ['nama_kategori' => 'Workshop & Pelatihan', 'warna_badge' => '#059669'],
            ['nama_kategori' => 'Seminar & Webinar', 'warna_badge' => '#2563eb'],
            ['nama_kategori' => 'Kompetisi & Lomba', 'warna_badge' => '#dc2626'],
            ['nama_kategori' => 'Pengabdian Masyarakat', 'warna_badge' => '#d97706'],
            ['nama_kategori' => 'Bazar & Festival', 'warna_badge' => '#7c3aed'],
        ];

        foreach ($kategoris as $k) {
            MasterKategoriEvent::firstOrCreate(
                ['nama_kategori' => $k['nama_kategori']],
                ['warna_badge' => $k['warna_badge']]
            );
        }

        // 7. Data Referensi Master Benefit SKP (M2)
        $benefits = [
            ['nama_benefit' => 'Peserta Kegiatan Ormawa', 'bobot_poin' => 10],
            ['nama_benefit' => 'Panitia Pelaksana Kegiatan', 'bobot_poin' => 15],
            ['nama_benefit' => 'Juara Kompetisi / Lomba', 'bobot_poin' => 25],
        ];

        foreach ($benefits as $b) {
            MasterBenefitSkp::firstOrCreate(
                ['nama_benefit' => $b['nama_benefit']],
                ['bobot_poin' => $b['bobot_poin']]
            );
        }
    }
}
