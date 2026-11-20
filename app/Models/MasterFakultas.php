<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['kode_fakultas', 'nama_fakultas'])]
class MasterFakultas extends Model
{
    protected $table = 'master_fakultas';

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'fakultas_id');
    }
}