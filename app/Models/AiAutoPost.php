<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiAutoPost extends Model
{
    protected $fillable = [
        'platform',
        'post_type',
        'product_id',
        'content',
        'media_urls',
        'hashtags',
        'status',
        'external_post_id',
        'post_url',
        'scheduled_for',
        'posted_at',
        'engagement_metrics',
        'error_message',
    ];

    protected $casts = [
        'media_urls' => 'array',
        'hashtags' => 'array',
        'scheduled_for' => 'datetime',
        'posted_at' => 'datetime',
        'engagement_metrics' => 'array',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Posts agendados
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Posts publicados
     */
    public function scopePosted($query)
    {
        return $query->where('status', 'posted');
    }

    /**
     * Posts pendentes de publicação
     */
    public function scopePending($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('scheduled_for', '<=', now());
    }

    /**
     * Posts por plataforma
     */
    public function scopeByPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }
}
