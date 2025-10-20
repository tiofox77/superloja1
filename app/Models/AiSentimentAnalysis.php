<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiSentimentAnalysis extends Model
{
    protected $table = 'ai_sentiment_analysis';

    protected $fillable = [
        'message_id',
        'conversation_id',
        'sentiment',
        'confidence',
        'emotions',
        'keywords',
        'needs_human_attention',
        'priority',
    ];

    protected $casts = [
        'confidence' => 'decimal:2',
        'emotions' => 'array',
        'keywords' => 'array',
        'needs_human_attention' => 'boolean',
    ];

    public function message(): BelongsTo
    {
        return $this->belongsTo(AiMessage::class, 'message_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(AiConversation::class, 'conversation_id');
    }

    /**
     * Sentimentos que precisam atenção
     */
    public function scopeNeedsAttention($query)
    {
        return $query->where('needs_human_attention', true);
    }

    /**
     * Por sentimento
     */
    public function scopeBySentiment($query, string $sentiment)
    {
        return $query->where('sentiment', $sentiment);
    }
}
