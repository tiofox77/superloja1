<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SocialMediaPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'content',
        'images',
        'scheduled_at',
        'published_at',
        'status',
        'external_id',
        'product_ids',
        'engagement_stats',
        'ai_generated',
        'hashtags',
    ];

    protected $casts = [
        'images' => 'array',
        'product_ids' => 'array',
        'engagement_stats' => 'array',
        'hashtags' => 'array',
        'scheduled_at' => 'datetime',
        'published_at' => 'datetime',
        'ai_generated' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'social_media_post_products');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeFacebook($query)
    {
        return $query->where('platform', 'facebook');
    }

    public function scopeInstagram($query)
    {
        return $query->where('platform', 'instagram');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'published' => 'green',
            'scheduled' => 'blue',
            'draft' => 'gray',
            'failed' => 'red',
            default => 'gray'
        };
    }

    public function getPlatformIconAttribute(): string
    {
        return match($this->platform) {
            'facebook' => '📘',
            'instagram' => '📷',
            'both' => '🌐',
            default => '📱'
        };
    }

    public function getEngagementRateAttribute(): float
    {
        $stats = $this->engagement_stats ?? [];
        $impressions = $stats['impressions'] ?? 0;
        $engagements = ($stats['likes'] ?? 0) + ($stats['comments'] ?? 0) + ($stats['shares'] ?? 0);
        
        return $impressions > 0 ? round(($engagements / $impressions) * 100, 2) : 0;
    }
}
