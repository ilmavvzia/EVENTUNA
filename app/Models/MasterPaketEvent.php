<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nama_kegiatan', 'kategori_id', 'benefit_skp_id', 'fakultas_id', 'jenis_ormawa_id'])]
class MasterPaketEvent extends Model
{
    protected $table = 'master_paket_events';

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(MasterKategoriEvent::class, 'kategori_id');
    }

    public function benefitSkp(): BelongsTo
    {
        return $this->belongsTo(MasterBenefitSkp::class, 'benefit_skp_id');
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(MasterFakultas::class, 'fakultas_id');
    }

    public function jenisOrmawa(): BelongsTo
    {
        return $this->belongsTo(MasterJenisOrmawa::class, 'jenis_ormawa_id');
    }
}