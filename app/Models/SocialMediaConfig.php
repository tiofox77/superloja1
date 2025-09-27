<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialMediaConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform',
        'page_id',
        'access_token',
        'app_id',
        'app_secret',
        'is_active',
        'auto_post',
        'post_settings',
        'token_expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'auto_post' => 'boolean',
        'post_settings' => 'array',
        'token_expires_at' => 'datetime',
    ];

    protected $hidden = [
        'access_token',
        'app_secret',
    ];

    /**
     * Get config for a specific platform
     */
    public static function getConfig(string $platform): ?self
    {
        return static::where('platform', $platform)->first();
    }

    /**
     * Check if platform is configured and active
     */
    public static function isConfigured(string $platform): bool
    {
        $config = static::getConfig($platform);
        return $config && $config->is_active && $config->access_token;
    }

    /**
     * Check if token is expired
     */
    public function isTokenExpired(): bool
    {
        if (!$this->token_expires_at) {
            return false;
        }
        
        return $this->token_expires_at->isPast();
    }

    /**
     * Get active platforms for auto posting
     */
    public static function getAutoPostPlatforms(): array
    {
        return static::where('is_active', true)
            ->where('auto_post', true)
            ->whereNotNull('access_token')
            ->pluck('platform')
            ->toArray();
    }
}
