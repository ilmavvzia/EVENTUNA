<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status_akun',
        'fakultas_id',
        'jenis_ormawa_id',
        'deskripsi_singkat',
        'logo_path',
        'sk_kepengurusan_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi User dengan Role.
     */
    public function userRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Memeriksa role pengguna.
     * Mendukung satu role atau beberapa role.
     */
    public function hasRole(string|array $roleName): bool
    {
        $currentRole = $this->userRole?->name;

        if (is_array($roleName)) {
            return in_array($currentRole, $roleName, true);
        }

        return $currentRole === $roleName;
    }

    /**
     * Memeriksa apakah pengguna adalah Admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Memeriksa apakah pengguna adalah Ormawa.
     */
    public function isOrmawa(): bool
    {
        return $this->hasRole('ormawa');
    }

    /**
     * Relasi User dengan Fakultas.
     */
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(MasterFakultas::class, 'fakultas_id');
    }

    /**
     * Relasi User dengan Jenis Ormawa.
     */
    public function jenisOrmawa(): BelongsTo
    {
        return $this->belongsTo(MasterJenisOrmawa::class, 'jenis_ormawa_id');
    }

    /**
     * Relasi User dengan Event.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id');
    }
}
