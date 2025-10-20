<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiPerformanceMetrics extends Model
{
    protected $fillable = [
        'metric_date',
        'total_conversations',
        'successful_responses',
        'failed_responses',
        'response_success_rate',
        'conversions',
        'conversion_rate',
        'avg_response_time_seconds',
        'human_interventions',
        'top_questions',
        'top_products',
        'customer_satisfaction_score',
    ];

    protected $casts = [
        'metric_date' => 'date',
        'total_conversations' => 'integer',
        'successful_responses' => 'integer',
        'failed_responses' => 'integer',
        'response_success_rate' => 'decimal:2',
        'conversions' => 'integer',
        'conversion_rate' => 'decimal:2',
        'avg_response_time_seconds' => 'decimal:2',
        'human_interventions' => 'integer',
        'top_questions' => 'array',
        'top_products' => 'array',
        'customer_satisfaction_score' => 'decimal:2',
    ];

    /**
     * Métricas recentes
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('metric_date', '>=', now()->subDays($days))
                    ->orderByDesc('metric_date');
    }
}
