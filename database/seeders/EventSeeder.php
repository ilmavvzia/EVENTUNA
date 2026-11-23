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
        $workshop = MasterKategoriEvent::where('nama_kategori', 'Workshop & Pelatihan')->first();
        $seminar = MasterKategoriEvent::where('nama_kategori', 'Seminar & Webinar')->first();
        $skp = MasterBenefitSkp::first();

        if ($himti && $workshop && $skp) {
            $event1 = Event::firstOrCreate(
                ['slug' => 'workshop-fullstack-laravel-himti-2026'],
                [
                    'user_id'              => $himti->id,
                    'kategori_id'          => $workshop->id,
                    'benefit_skp_id'       => $skp->id,
                    'judul_event'          => 'Workshop Fullstack Web Development Laravel 13 & PostgreSQL',
                    'deskripsi'            => 'Pelatihan intensif pembuatan portal web modern menggunakan framework Laravel dan basis data relasional PostgreSQL untuk mahasiswa.',
                    'tanggal_mulai'        => now()->addDays(7)->toDateString(),
                    'tanggal_selesai'      => now()->addDays(7)->toDateString(),
                    'lokasi_atau_platform' => 'Lab Komputer Gedung B Fakultas Vokasi',
                    'link_pendaftaran'     => 'https://forms.gle/contoh-workshop-himti',
                    'status_publikasi'     => 'published',
                ]
            );

            if ($event1->rundowns()->count() === 0) {
                $event1->rundowns()->createMany([
                    [
                        'waktu_mulai'       => '08:00:00',
                        'waktu_selesai'     => '08:30:00',
                        'nama_sesi'         => 'Registrasi Peserta & Check-in',
                        'pemateri_atau_pic' => 'Divisi Kesekretariatan HIMTI',
                    ],
                    [
                        'waktu_mulai'       => '08:30:00',
                        'waktu_selesai'     => '09:00:00',
                        'nama_sesi'         => 'Pembukaan & Sambutan Kaprodi',
                        'pemateri_atau_pic' => 'MC & Koordinator Program Studi',
                    ],
                    [
                        'waktu_mulai'       => '09:00:00',
                        'waktu_selesai'     => '11:30:00',
                        'nama_sesi'         => 'Sesi Inti: Arsitektur MVC & Integrasi PostgreSQL',
                        'pemateri_atau_pic' => 'Praktisi Software Engineer',
                    ],
                    [
                        'waktu_mulai'       => '11:30:00',
                        'waktu_selesai'     => '12:30:00',
                        'nama_sesi'         => 'Hands-on Coding & Tanya Jawab',
                        'pemateri_atau_pic' => 'Tim Asisten Laboratorium',
                    ],
                ]);
            }
        }

        if ($himti && $seminar && $skp) {
            $event2 = Event::firstOrCreate(
                ['slug' => 'seminar-nasional-karir-digital-2026'],
                [
                    'user_id'              => $himti->id,
                    'kategori_id'          => $seminar->id,
                    'benefit_skp_id'       => $skp->id,
                    'judul_event'          => 'Seminar Nasional: Strategi Karir Digital & Portofolio Mahasiswa',
                    'deskripsi'            => 'Bincang inspiratif mengenai penyusunan portofolio profesional dan sertifikasi keahlian untuk menunjang poin SKP kelulusan.',
                    'tanggal_mulai'        => now()->addDays(14)->toDateString(),
                    'tanggal_selesai'      => now()->addDays(14)->toDateString(),
                    'lokasi_atau_platform' => 'Auditorium Kampus B UNAIR / Zoom Meeting',
                    'link_pendaftaran'     => 'https://forms.gle/contoh-seminar-himti',
                    'status_publikasi'     => 'published',
                ]
            );

            if ($event2->rundowns()->count() === 0) {
                $event2->rundowns()->createMany([
                    [
                        'waktu_mulai'       => '09:00:00',
                        'waktu_selesai'     => '09:30:00',
                        'nama_sesi'         => 'Pembukaan & Keynote Speech',
                        'pemateri_atau_pic' => 'Ketua BEM & Kemahasiswaan',
                    ],
                    [
                        'waktu_mulai'       => '09:30:00',
                        'waktu_selesai'     => '11:30:00',
                        'nama_sesi'         => 'Pemaparan Materi: Tren Industri Teknologi 2026',
                        'pemateri_atau_pic' => 'Tech Lead & Alumnus Berprestasi',
                    ],
                    [
                        'waktu_mulai'       => '11:30:00',
                        'waktu_selesai'     => '12:00:00',
                        'nama_sesi'         => 'Sesi Tanya Jawab & Doorprize',
                        'pemateri_atau_pic' => 'Moderator Acara',
                    ],
                ]);
            }
        }
    }
}
