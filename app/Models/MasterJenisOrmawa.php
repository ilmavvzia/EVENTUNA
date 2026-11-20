<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_jenis', 'deskripsi'])]
class MasterJenisOrmawa extends Model
{
    protected $table = 'master_jenis_ormawa';

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'jenis_ormawa_id');
    }
}