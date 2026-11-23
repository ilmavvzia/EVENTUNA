<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventRundown;
use App\Models\MasterBenefitSkp;
use App\Models\MasterKategoriEvent;
use App\Models\User;
use Tests\TestCase;

class Anggota1VerificationTest extends TestCase
{
    protected User $admin;
    protected User $ormawa;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('email', 'admin@eventuna.ac.id')->firstOrFail();
        $this->ormawa = User::where('email', 'himti@vokasi.unair.ac.id')->firstOrFail();
    }

    /**
     * 1. Halaman utama terbuka baca-saja untuk Guest tanpa login.
     */
    public function test_guest_can_access_home_and_public_event(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('EVENTUNA');

        $event = Event::where('status_publikasi', 'published')->first();
        if ($event) {
            $showResponse = $this->get('/event/' . $event->slug);
            $showResponse->assertStatus(200);
            $showResponse->assertSee($event->judul_event);
            $showResponse->assertSee('Susunan Jadwal', false);
        }
    }

    /**
     * 2. Proteksi RBAC: Guest dialihkan ke login saat akses rute terproteksi.
     */
    public function test_guest_is_redirected_to_login_on_protected_routes(): void
    {
        $this->get('/events')->assertRedirect(route('login'));
        $this->get('/admin/kategori')->assertRedirect(route('login'));
    }

    /**
     * 3. Proteksi RBAC Sisi Server: Ormawa ditolak dengan respon 403 Forbidden saat akses Admin.
     */
    public function test_ormawa_gets_403_forbidden_when_accessing_admin_kategori(): void
    {
        $response = $this->actingAs($this->ormawa)->get('/admin/kategori');
        $response->assertStatus(403);
    }

    /**
     * 4. Helper hasRole() pada Model User berfungsi tepat.
     */
    public function test_user_has_role_helper(): void
    {
        $this->assertTrue($this->admin->hasRole('admin'));
        $this->assertFalse($this->admin->hasRole('ormawa'));

        $this->assertTrue($this->ormawa->hasRole('ormawa'));
        $this->assertFalse($this->ormawa->hasRole('admin'));
    }

    /**
     * 5. Super Admin dapat mengakses dan mengelola Master Kategori Event (M1).
     */
    public function test_admin_can_crud_master_kategori(): void
    {
        // Index
        $response = $this->actingAs($this->admin)->get(route('admin.kategori.index'));
        $response->assertStatus(200);

        // Pencarian ILIKE
        $searchResponse = $this->actingAs($this->admin)->get(route('admin.kategori.index', ['search' => 'workshop']));
        $searchResponse->assertStatus(200);

        // Create & Store
        $namaKategoriBaru = 'Kategori Uji ' . uniqid();
        $storeResponse = $this->actingAs($this->admin)->post(route('admin.kategori.store'), [
            'nama_kategori' => $namaKategoriBaru,
            'warna_badge'   => '#10b981',
        ]);
        $storeResponse->assertRedirect(route('admin.kategori.index'));

        $kategori = MasterKategoriEvent::where('nama_kategori', $namaKategoriBaru)->first();
        $this->assertNotNull($kategori);

        // Edit & Update
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.kategori.update', $kategori), [
            'nama_kategori' => $namaKategoriBaru . ' Updated',
            'warna_badge'   => '#065f46',
        ]);
        $updateResponse->assertRedirect(route('admin.kategori.index'));

        // Delete (berhasil karena belum dipakai event)
        $kategori->refresh();
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.kategori.destroy', $kategori));
        $deleteResponse->assertRedirect(route('admin.kategori.index'));
        $this->assertDatabaseMissing('master_kategori_event', ['id' => $kategori->id]);
    }

    /**
     * 6. Pencegahan hapus (destroy) jika kategori sudah digunakan oleh event.
     */
    public function test_cannot_delete_category_in_use(): void
    {
        $kategoriDipakai = MasterKategoriEvent::has('events')->first();
        if ($kategoriDipakai) {
            $response = $this->actingAs($this->admin)->delete(route('admin.kategori.destroy', $kategoriDipakai));
            $response->assertSessionHas('error');
            $this->assertDatabaseHas('master_kategori_event', ['id' => $kategoriDipakai->id]);
        }
    }

    /**
     * 7. Transaksi 1 (T1): Ormawa dapat menyimpan Event Header dan Detail Rundown secara atomik.
     */
    public function test_ormawa_can_store_event_header_and_rundown_details(): void
    {
        $kategori = MasterKategoriEvent::firstOrFail();
        $benefit  = MasterBenefitSkp::firstOrFail();

        $judul = 'Uji Coba Event T1 ' . uniqid();
        $postData = [
            'judul_event'          => $judul,
            'kategori_id'          => $kategori->id,
            'benefit_skp_id'       => $benefit->id,
            'deskripsi'            => 'Deskripsi uji coba penyimpanan atomik event dan rundown acara.',
            'tanggal_mulai'        => now()->addDays(5)->toDateString(),
            'tanggal_selesai'      => now()->addDays(5)->toDateString(),
            'lokasi_atau_platform' => 'Ruang Seminar Vokasi',
            'link_pendaftaran'     => 'https://forms.gle/test-pendaftaran',
            'status_publikasi'     => 'published',
            'rundowns'             => [
                [
                    'waktu_mulai'       => '08:00',
                    'waktu_selesai'     => '09:00',
                    'nama_sesi'         => 'Sesi 1: Registrasi & Pembukaan',
                    'pemateri_atau_pic' => 'Divisi Acara',
                ],
                [
                    'waktu_mulai'       => '09:00',
                    'waktu_selesai'     => '11:00',
                    'nama_sesi'         => 'Sesi 2: Pemaparan Materi Inti',
                    'pemateri_atau_pic' => 'Narasumber Tamu',
                ],
            ],
        ];

        $response = $this->actingAs($this->ormawa)->post(route('events.store'), $postData);
        $response->assertRedirect(route('events.index'));

        // Verifikasi Header tersimpan
        $event = Event::where('judul_event', $judul)->first();
        $this->assertNotNull($event);
        $this->assertEquals($this->ormawa->id, $event->user_id);
        $this->assertNotEmpty($event->slug);

        // Verifikasi Detail Rundown tersimpan
        $this->assertCount(2, $event->rundowns);
        $this->assertDatabaseHas('event_rundowns', [
            'event_id'  => $event->id,
            'nama_sesi' => 'Sesi 1: Registrasi & Pembukaan',
        ]);
        $this->assertDatabaseHas('event_rundowns', [
            'event_id'  => $event->id,
            'nama_sesi' => 'Sesi 2: Pemaparan Materi Inti',
        ]);
    }

    /**
     * 8. Validasi Server-Side: T1 gagal simpan jika detail rundown kosong.
     */
    public function test_event_store_validation_fails_without_rundowns(): void
    {
        $kategori = MasterKategoriEvent::firstOrFail();
        $benefit  = MasterBenefitSkp::firstOrFail();

        $response = $this->actingAs($this->ormawa)->post(route('events.store'), [
            'judul_event'          => 'Event Tanpa Rundown',
            'kategori_id'          => $kategori->id,
            'benefit_skp_id'       => $benefit->id,
            'deskripsi'            => 'Deskripsi uji coba.',
            'tanggal_mulai'        => now()->toDateString(),
            'lokasi_atau_platform' => 'Lab',
            'link_pendaftaran'     => 'https://forms.gle/link',
            'status_publikasi'     => 'published',
            // rundowns tidak dikirim
        ]);

        $response->assertSessionHasErrors(['rundowns']);
    }
}
