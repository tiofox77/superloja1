<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiAgentConfig extends Model
{
    protected $table = 'ai_agent_config';

    protected $fillable = [
        'name',
        'is_active',
        'instagram_enabled',
        'messenger_enabled',
        'auto_post_enabled',
        'system_prompt',
        'capabilities',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'instagram_enabled' => 'boolean',
        'messenger_enabled' => 'boolean',
        'auto_post_enabled' => 'boolean',
        'capabilities' => 'array',
        'settings' => 'array',
    ];

    /**
     * Obter configuração ativa do agent
     */
    public static function getActive(): ?self
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Verificar se uma capability está habilitada
     */
    public function hasCapability(string $capability): bool
    {
        return in_array($capability, $this->capabilities ?? []);
    }

    /**
     * Obter configuração específica
     */
    public function getSetting(string $key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }
}
