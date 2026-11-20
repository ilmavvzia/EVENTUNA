<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_kategori', 'warna_badge'])]
class MasterKategoriEvent extends Model
{
    protected $table = 'master_kategori_event';

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'kategori_id');
    }
}