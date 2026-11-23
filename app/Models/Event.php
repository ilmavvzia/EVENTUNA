<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
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
    ];

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

    /**
     * Relasi Header-Detail (T1): Satu Event memiliki banyak sesi rundown acara.
     */
    public function rundowns(): HasMany
    {
        return $this->hasMany(EventRundown::class, 'event_id');
    }
}
