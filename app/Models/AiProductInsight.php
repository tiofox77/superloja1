<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiProductInsight extends Model
{
    protected $fillable = [
        'product_id',
        'total_views',
        'total_sales',
        'total_revenue',
        'conversion_rate',
        'times_recommended',
        'times_clicked',
        'avg_rating',
        'customer_questions',
        'ai_recommendations',
        'performance_status',
        'analysis_date',
    ];

    protected $casts = [
        'total_views' => 'integer',
        'total_sales' => 'integer',
        'total_revenue' => 'decimal:2',
        'conversion_rate' => 'decimal:2',
        'times_recommended' => 'integer',
        'times_clicked' => 'integer',
        'avg_rating' => 'decimal:2',
        'customer_questions' => 'array',
        'ai_recommendations' => 'array',
        'analysis_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Produtos com melhor performance
     */
    public function scopeHotProducts($query)
    {
        return $query->where('performance_status', 'hot')
                    ->orderByDesc('total_revenue');
    }

    /**
     * Produtos com baixa performance
     */
    public function scopeColdProducts($query)
    {
        return $query->where('performance_status', 'cold')
                    ->orderBy('total_sales');
    }

    /**
     * Insights mais recentes
     */
    public function scopeRecent($query)
    {
        return $query->orderByDesc('analysis_date');
    }
}
