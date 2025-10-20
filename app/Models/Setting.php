<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_encrypted'
    ];

    protected $casts = [
        'is_encrypted' => 'boolean'
    ];

    /**
     * Acessor para value - descriptografa se necessário
     */
    public function getValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return $value; // Retorna o valor original se falhar na descriptografia
            }
        }

        return $this->castValue($value);
    }

    /**
     * Mutator para value - criptografa se necessário
     */
    public function setValueAttribute($value)
    {
        if ($this->is_encrypted && $value) {
            $this->attributes['value'] = Crypt::encryptString($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Converte o valor para o tipo correto
     */
    private function castValue($value)
    {
        switch ($this->type) {
            case 'boolean':
                return (bool) $value;
            case 'number':
                return is_numeric($value) ? (float) $value : 0;
            case 'json':
                return json_decode($value, true) ?? [];
            default:
                return $value;
        }
    }

    /**
     * Buscar configuração por chave
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Definir configuração
     */
    public static function set($key, $value, $type = 'string', $group = 'general', $label = null, $description = null, $isEncrypted = false)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $label ?? $key,
                'description' => $description,
                'is_encrypted' => $isEncrypted
            ]
        );
    }

    /**
     * Buscar configurações por grupo
     */
    public static function getByGroup($group)
    {
        return static::where('group', $group)->orderBy('label')->get();
    }

    /**
     * Verificar se uma configuração existe
     */
    public static function has($key)
    {
        return static::where('key', $key)->exists();
    }
}
