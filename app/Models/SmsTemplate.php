<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'message',
        'is_active',
        'variables'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'variables' => 'array'
    ];

    /**
     * Substituir variáveis no template da mensagem
     */
    public function processMessage(array $data = [])
    {
        $message = $this->message;
        
        foreach ($data as $key => $value) {
            $message = str_replace('{{' . $key . '}}', $value, $message);
        }
        
        return $message;
    }

    /**
     * Verificar se o template está ativo
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Buscar template por tipo
     */
    public static function getByType(string $type)
    {
        return static::where('type', $type)->active()->first();
    }
}
