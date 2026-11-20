<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\MasterBenefitSkp;
use App\Models\MasterKategoriEvent;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $himti = User::where('email', 'himti@vokasi.unair.ac.id')->first();
        $bem = User::where('email', 'bem@vokasi.unair.ac.id')->first();

        $workshop = MasterKategoriEvent::where('nama_kategori', 'Workshop & Pelatihan')->first();
        $seminar = MasterKategoriEvent::where('nama_kategori', 'Seminar & Talkshow')->first();
        $lomba = MasterKategoriEvent::where('nama_kategori', 'Kompetisi & Lomba')->first();

        $skpFak = MasterBenefitSkp::where('bobot_poin', 15)->first();
        $skpUniv = MasterBenefitSkp::where('bobot_poin', 25)->first();

        if ($himti && $workshop && $skpFak) {
            Event::firstOrCreate(
                ['slug' => 'workshop-laravel-12-himti-2026'],
                [
                    'user_id' => $himti->id,
                    'kategori_id' => $workshop->id,
                    'benefit_skp_id' => $skpFak->id,
                    'judul_event' => 'Workshop Fullstack Web Development dengan Laravel 12',
                    'deskripsi' => 'Pelatihan praktis membangun aplikasi web modern menggunakan Laravel 12 dan Tailwind CSS khusus mahasiswa Vokasi.',
                    'tanggal_mulai' => now()->addDays(7)->toDateString(),
                    'tanggal_selesai' => now()->addDays(7)->toDateString(),
                    'lokasi_atau_platform' => 'Lab Komputer Gedung B Fakultas Vokasi',
                    'link_pendaftaran' => 'https://forms.gle/contoh-pendaftaran-himti',
                    'status_publikasi' => 'published',
                ]
            );
        }

        if ($bem && $seminar && $skpUniv) {
            Event::firstOrCreate(
                ['slug' => 'seminar-nasional-karir-digital-2026'],
                [
                    'user_id' => $bem->id,
                    'kategori_id' => $seminar->id,
                    'benefit_skp_id' => $skpUniv->id,
                    'judul_event' => 'Seminar Nasional: Strategi Menembus Karir Data & Teknologi 2026',
                    'deskripsi' => 'Bincang interaktif bersama praktisi industri teknologi mengenai persiapan portofolio dan magang berdampak.',
                    'tanggal_mulai' => now()->addDays(14)->toDateString(),
                    'tanggal_selesai' => now()->addDays(14)->toDateString(),
                    'lokasi_atau_platform' => 'Aula Candradimuka GKB Kampus C UNAIR',
                    'link_pendaftaran' => 'https://forms.gle/contoh-pendaftaran-bem',
                    'status_publikasi' => 'published',
                ]
            );
        }
    }
}