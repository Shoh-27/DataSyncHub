<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'account_status',
        'avatar_url',
        'bio',
        'timezone',
        'language',
        'skills',
        'profile_visibility',
        'two_factor_enabled',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'two_factor_enabled' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function oauthProviders()
    {
        return $this->hasMany(OauthProvider::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('account_status', 'active');
    }

    public function scopeFreelancers($query)
    {
        return $query->where('role', 'freelancer');
    }

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    // Helper methods
    public function isFreelancer(): bool
    {
        return $this->role === 'freelancer';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isActive(): bool
    {
        return $this->account_status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->account_status === 'suspended';
    }

    public function hasSkill(int $skillId): bool
    {
        return in_array($skillId, $this->skills ?? []);
    }
}
