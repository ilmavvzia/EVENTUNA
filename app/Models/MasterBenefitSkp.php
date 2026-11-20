<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_benefit', 'bobot_poin'])]
class MasterBenefitSkp extends Model
{
    protected $table = 'master_benefit_skp';

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'benefit_skp_id');
    }
}