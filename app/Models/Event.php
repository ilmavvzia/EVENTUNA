<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'kategori_id',
    'benefit_skp_id',
    'judul_event',
    'slug',
    'deskripsi',
    'tanggal_mulai',
    'tanggal_selesai',
    'lokasi_atau_platform',
    'link_pendaftaran',
    'poster_path',
    'status_publikasi',
    'status_approval',
    'approved_by',
    'catatan_penolakan',
    'waktu_keputusan',
])]
class Event extends Model
{
    protected $table = 'events';

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
            'waktu_keputusan' => 'datetime',
        ];
    }

    /**
     * Relasi: Event diajukan oleh satu Pengurus Ormawa (User).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi: Event disetujui / diproses oleh satu Super Admin (User).
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relasi: Kategori agenda event.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(MasterKategoriEvent::class, 'kategori_id');
    }

    /**
     * Relasi: Benefit & Poin SKP yang diperoleh mahasiswa.
     */
    public function benefitSkp(): BelongsTo
    {
        return $this->belongsTo(MasterBenefitSkp::class, 'benefit_skp_id');
    }

    /**
     * Scope: Event yang sedang menunggu persetujuan Admin Kemahasiswaan.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status_approval', 'pending');
    }

    /**
     * Scope: Event yang telah disetujui oleh Admin.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status_approval', 'approved');
    }

    /**
     * Scope: Event yang aktif dipublikasikan ke katalog publik mahasiswa (Guest).
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status_publikasi', 'published')
                     ->where('status_approval', 'approved');
    }
}
