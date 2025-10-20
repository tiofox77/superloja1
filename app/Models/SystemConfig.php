<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class SystemConfig extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_encrypted',
        'is_public',
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
        'is_public' => 'boolean',
    ];

    /**
     * Obter valor de configuração
     */
    public static function get(string $key, $default = null)
    {
        // Cache por 1 hora
        $cacheKey = 'system_config_' . $key;
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $config = self::where('key', $key)->first();
            
            if (!$config) {
                return $default;
            }
            
            $value = $config->value;
            
            // Descriptografar se necessário
            if ($config->is_encrypted && $value) {
                try {
                    $value = Crypt::decryptString($value);
                } catch (\Exception $e) {
                    return $default;
                }
            }
            
            // Converter para tipo apropriado
            return self::castValue($value, $config->type);
        });
    }

    /**
     * Definir valor de configuração
     */
    public static function set(string $key, $value, array $options = []): self
    {
        $type = $options['type'] ?? self::detectType($value);
        $isEncrypted = $options['is_encrypted'] ?? false;
        
        // Converter valor para string
        $stringValue = self::valueToString($value, $type);
        
        // Criptografar se necessário
        if ($isEncrypted && $stringValue) {
            $stringValue = Crypt::encryptString($stringValue);
        }
        
        $config = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'type' => $type,
                'group' => $options['group'] ?? null,
                'label' => $options['label'] ?? null,
                'description' => $options['description'] ?? null,
                'is_encrypted' => $isEncrypted,
                'is_public' => $options['is_public'] ?? false,
            ]
        );
        
        // Limpar cache
        Cache::forget('system_config_' . $key);
        
        return $config;
    }

    /**
     * Obter todas configurações de um grupo
     */
    public static function getGroup(string $group): array
    {
        $configs = self::where('group', $group)->get();
        $result = [];
        
        foreach ($configs as $config) {
            $value = $config->value;
            
            if ($config->is_encrypted && $value) {
                try {
                    $value = Crypt::decryptString($value);
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            $result[$config->key] = self::castValue($value, $config->type);
        }
        
        return $result;
    }

    /**
     * Detectar tipo do valor
     */
    private static function detectType($value): string
    {
        if (is_bool($value)) {
            return 'boolean';
        }
        
        if (is_int($value)) {
            return 'integer';
        }
        
        if (is_float($value)) {
            return 'float';
        }
        
        if (is_array($value)) {
            return 'json';
        }
        
        return 'string';
    }

    /**
     * Converter valor para string
     */
    private static function valueToString($value, string $type): string
    {
        if ($type === 'boolean') {
            return $value ? '1' : '0';
        }
        
        if ($type === 'json') {
            return json_encode($value);
        }
        
        return (string) $value;
    }

    /**
     * Converter string para tipo apropriado
     */
    private static function castValue(?string $value, string $type)
    {
        if ($value === null) {
            return null;
        }
        
        return match($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            default => $value,
        };
    }

    /**
     * Verificar se configuração existe
     */
    public static function has(string $key): bool
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Deletar configuração
     */
    public static function forget(string $key): bool
    {
        Cache::forget('system_config_' . $key);
        return self::where('key', $key)->delete() > 0;
    }

    /**
     * Limpar todo o cache de configurações
     */
    public static function clearCache(): void
    {
        $configs = self::all();
        foreach ($configs as $config) {
            Cache::forget('system_config_' . $config->key);
        }
    }
}
