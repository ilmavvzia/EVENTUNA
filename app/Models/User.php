<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'status_akun',
    'fakultas_id',
    'jenis_ormawa_id',
    'deskripsi_singkat',
    'logo_path',
    'sk_kepengurusan_path',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: Satu Ormawa (User) memiliki banyak Event.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Relasi: Ormawa (User) bernaung di satu Fakultas.
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(MasterFakultas::class, 'fakultas_id');
    }

    /**
     * Relasi: Ormawa (User) termasuk dalam satu Jenis Ormawa.
     */
    public function jenisOrmawa(): BelongsTo
    {
        return $this->belongsTo(MasterJenisOrmawa::class, 'jenis_ormawa_id');
    }
}