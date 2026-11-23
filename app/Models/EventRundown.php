<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRundown extends Model
{
    use HasFactory;

    protected $table = 'event_rundowns';

    protected $fillable = [
        'event_id',
        'waktu_mulai',
        'waktu_selesai',
        'nama_sesi',
        'pemateri_atau_pic',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
