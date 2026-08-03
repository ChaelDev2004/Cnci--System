<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_BRANCH = 'branch';

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'role',
        'pastor_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'role' => self::ROLE_SUPER_ADMIN,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function ensureColumns(): void
    {
        try {
            if (! Schema::hasColumn('users', 'role')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->string('role', 32)->default(self::ROLE_SUPER_ADMIN)->after('email');
                });
            }
            if (! Schema::hasColumn('users', 'pastor_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unsignedBigInteger('pastor_id')->nullable()->after('role');
                });
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }

    public function pastor(): BelongsTo
    {
        return $this->belongsTo(Pastor::class);
    }

    public function isSuperAdmin(): bool
    {
        return ($this->role ?? self::ROLE_SUPER_ADMIN) === self::ROLE_SUPER_ADMIN;
    }

    public function isBranch(): bool
    {
        return ($this->role ?? '') === self::ROLE_BRANCH;
    }

    public function assignedPastorId(): ?int
    {
        return $this->pastor_id ? (int) $this->pastor_id : null;
    }

    public function canManagePastor(?int $pastorId): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->isBranch()
            && $pastorId
            && $this->assignedPastorId() === (int) $pastorId;
    }

    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return asset('assets/img/avatars/1.png');
    }
}
