<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterKategoriEvent extends Model
{
    use HasFactory;

    protected $table = 'master_kategori_event';

    protected $fillable = [
        'nama_kategori',
        'warna_badge',
    ];

    /**
     * Relasi hasMany ke data Event:
     * Digunakan untuk validasi pencegahan hapus (destroy) jika kategori masih dipakai.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'kategori_id');
    }
}
