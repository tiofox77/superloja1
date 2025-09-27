<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialMediaAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'account_name',
        'page_id',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'is_active',
        'auto_post',
        'post_schedule',
        'settings',
    ];

    protected $casts = [
        'token_expires_at' => 'datetime',
        'is_active' => 'boolean',
        'auto_post' => 'boolean',
        'post_schedule' => 'array',
        'settings' => 'array',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(SocialMediaPost::class, 'account_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFacebook($query)
    {
        return $query->where('platform', 'facebook');
    }

    public function scopeInstagram($query)
    {
        return $query->where('platform', 'instagram');
    }

    public function isTokenExpired(): bool
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }

    public function getPlatformColorAttribute(): string
    {
        return match($this->platform) {
            'facebook' => 'blue',
            'instagram' => 'pink',
            default => 'gray'
        };
    }
}
