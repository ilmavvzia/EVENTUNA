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
            'password'          => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Helper hasRole() untuk verifikasi otorisasi RBAC (Role-Based Access Control).
     * Menerima string tunggal atau array nama role.
     */
    public function hasRole(string|array $roleName): bool
    {
        if (is_array($roleName)) {
            return in_array($this->role?->name, $roleName, true);
        }

        return $this->role?->name === $roleName;
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(MasterFakultas::class, 'fakultas_id');
    }

    public function jenisOrmawa(): BelongsTo
    {
        return $this->belongsTo(MasterJenisOrmawa::class, 'jenis_ormawa_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'user_id');
    }
}
