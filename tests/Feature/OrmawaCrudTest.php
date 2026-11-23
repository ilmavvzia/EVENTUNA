<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\MasterFakultas;
use App\Models\MasterJenisOrmawa;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class OrmawaCrudTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    /**
     * 1. Test Halaman Publik Guest
     */
    public function test_guest_can_access_homepage_catalog(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Temukan Seminar, Lomba, & Pelatihan Kampus Terbaru');
    }

    /**
     * 2. Test Dashboard Super Admin
     */
    public function test_admin_dashboard_displays_real_statistics(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Ringkasan Statistik Sistem');
        $response->assertSee('Antrean Approval Event');
    }

    /**
     * 3. Test Dashboard Ormawa
     */
    public function test_ormawa_dashboard_displays_dynamic_event_data(): void
    {
        $response = $this->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Pengurus Ormawa');
    }

    /**
     * 4. Test CRUD Ormawa
     */
    public function test_admin_can_view_ormawa_index_and_create(): void
    {
        $response = $this->get('/admin/ormawa');
        $response->assertStatus(200);
        $response->assertSee('Direktori Organisasi Mahasiswa');

        $responseCreate = $this->get('/admin/ormawa/create');
        $responseCreate->assertStatus(200);
        $responseCreate->assertSee('Daftarkan Organisasi Mahasiswa Baru');
    }

    /**
     * 5. Test Approval Event Index & Detail
     */
    public function test_admin_can_view_approval_queue(): void
    {
        $response = $this->get('/admin/approval');
        $response->assertStatus(200);
        $response->assertSee('Approval Pengajuan Event Mahasiswa');
    }

    /**
     * 6. Test Transaksi Approval Setujui Event
     */
    public function test_admin_can_approve_event(): void
    {
        $event = Event::first();
        if (!$event) {
            $this->markTestSkipped('Tidak ada event di database');
        }

        $response = $this->post("/admin/approval/{$event->id}/approve");
        $response->assertRedirect('/admin/approval');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('events', [
            'id'               => $event->id,
            'status_approval'  => 'approved',
            'status_publikasi' => 'published',
        ]);
    }

    /**
     * 7. Test Transaksi Penolakan Event
     */
    public function test_admin_can_reject_event(): void
    {
        $event = Event::first();
        if (!$event) {
            $this->markTestSkipped('Tidak ada event di database');
        }

        $response = $this->post("/admin/approval/{$event->id}/reject", [
            'catatan_penolakan' => 'Proposal perlu revisi pada jadwal sesi 2.',
        ]);
        $response->assertRedirect('/admin/approval');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('events', [
            'id'                => $event->id,
            'status_approval'   => 'rejected',
            'status_publikasi'  => 'draft',
            'catatan_penolakan' => 'Proposal perlu revisi pada jadwal sesi 2.',
        ]);
    }
}
