<?php

namespace Database\Seeders;

use App\Models\MasterBenefitSkp;
use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use App\Models\MasterKategoriEvent;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Master Fakultas
        $fakultas = [
            ['kode_fakultas' => 'FV', 'nama_fakultas' => 'Fakultas Vokasi'],
            ['kode_fakultas' => 'FST', 'nama_fakultas' => 'Fakultas Sains dan Teknologi'],
            ['kode_fakultas' => 'FEB', 'nama_fakultas' => 'Fakultas Ekonomi dan Bisnis'],
            ['kode_fakultas' => 'FISIP', 'nama_fakultas' => 'Fakultas Ilmu Sosial dan Ilmu Politik'],
            ['kode_fakultas' => 'FK', 'nama_fakultas' => 'Fakultas Kedokteran'],
            ['kode_fakultas' => 'UNIV', 'nama_fakultas' => 'Tingkat Universitas (Pusat)'],
        ];
        foreach ($fakultas as $item) {
            MasterFakultas::firstOrCreate(['kode_fakultas' => $item['kode_fakultas']], $item);
        }

        // 2. Data Master Jenis Ormawa
        $jenisOrmawa = [
            ['nama_jenis' => 'BEM', 'deskripsi' => 'Badan Eksekutif Mahasiswa tingkat Fakultas maupun Universitas'],
            ['nama_jenis' => 'HIMA', 'deskripsi' => 'Himpunan Mahasiswa Program Studi'],
            ['nama_jenis' => 'UKM', 'deskripsi' => 'Unit Kegiatan Mahasiswa'],
            ['nama_jenis' => 'BLM', 'deskripsi' => 'Badan Legislatif Mahasiswa'],
            ['nama_jenis' => 'ORMADA', 'deskripsi' => 'Organisasi Mahasiswa Daerah'],
        ];
        foreach ($jenisOrmawa as $item) {
            MasterJenisOrmawa::firstOrCreate(['nama_jenis' => $item['nama_jenis']], $item);
        }

        // 3. Data Master Kategori Event
        $kategoriEvent = [
            ['nama_kategori' => 'Seminar & Talkshow', 'warna_badge' => '#7c3aed'],
            ['nama_kategori' => 'Webinar Nasional', 'warna_badge' => '#2563eb'],
            ['nama_kategori' => 'Workshop & Pelatihan', 'warna_badge' => '#059669'],
            ['nama_kategori' => 'Kompetisi & Lomba', 'warna_badge' => '#dc2626'],
            ['nama_kategori' => 'Pengabdian Masyarakat', 'warna_badge' => '#d97706'],
        ];
        foreach ($kategoriEvent as $item) {
            MasterKategoriEvent::firstOrCreate(['nama_kategori' => $item['nama_kategori']], $item);
        }

        // 4. Data Master Benefit & Bobot SKP
        $benefitSkp = [
            ['nama_benefit' => 'SKP Tingkat Program Studi + E-Sertifikat', 'bobot_poin' => 10],
            ['nama_benefit' => 'SKP Tingkat Fakultas + E-Sertifikat', 'bobot_poin' => 15],
            ['nama_benefit' => 'SKP Tingkat Universitas + E-Sertifikat', 'bobot_poin' => 25],
            ['nama_benefit' => 'SKP Nasional / Internasional + Sertifikat Resmi', 'bobot_poin' => 40],
            ['nama_benefit' => 'E-Sertifikat Peserta (Non-SKP)', 'bobot_poin' => 0],
        ];
        foreach ($benefitSkp as $item) {
            MasterBenefitSkp::firstOrCreate(['nama_benefit' => $item['nama_benefit']], $item);
        }
    }
}