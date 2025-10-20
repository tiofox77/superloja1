<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiIntegrationToken extends Model
{
    protected $fillable = [
        'platform',
        'access_token',
        'refresh_token',
        'page_id',
        'page_name',
        'expires_at',
        'is_active',
        'permissions',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'permissions' => 'array',
    ];

    /**
     * Obter token por plataforma
     */
    public static function getByPlatform(string $platform): ?self
    {
        return self::where('platform', $platform)
                  ->where('is_active', true)
                  ->first();
    }

    /**
     * Verificar se token está expirado
     */
    public function isExpired(): bool
    {
        if (!$this->expires_at) {
            return false;
        }
        
        return now()->isAfter($this->expires_at);
    }

    /**
     * Verificar se token tem uma permissão específica
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions ?? []);
    }
}
