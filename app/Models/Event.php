<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
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
])]
class Event extends Model
{
    protected $table = 'events';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(MasterKategoriEvent::class, 'kategori_id');
    }

    public function benefitSkp(): BelongsTo
    {
        return $this->belongsTo(MasterBenefitSkp::class, 'benefit_skp_id');
    }
}