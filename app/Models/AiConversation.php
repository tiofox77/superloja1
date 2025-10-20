<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiConversation extends Model
{
    protected $fillable = [
        'platform',
        'external_id',
        'customer_name',
        'customer_identifier',
        'customer_phone',
        'customer_email',
        'user_id',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(AiMessage::class, 'conversation_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(AiMessage::class, 'conversation_id')->latest();
    }

    /**
     * Obter conversas ativas
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Obter conversas por plataforma
     */
    public function scopeByPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    /**
     * Adicionar mensagem à conversa
     */
    public function addMessage(string $message, string $direction, string $senderType, ?array $metadata = null): AiMessage
    {
        $aiMessage = $this->messages()->create([
            'direction' => $direction,
            'sender_type' => $senderType,
            'message' => $message,
            'metadata' => $metadata,
            'sent_at' => now(),
        ]);

        $this->update(['last_message_at' => now()]);

        return $aiMessage;
    }
}
