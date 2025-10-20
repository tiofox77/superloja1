<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiKnowledgeBase extends Model
{
    protected $table = 'ai_knowledge_base';

    protected $fillable = [
        'category',
        'question',
        'answer',
        'keywords',
        'times_used',
        'times_successful',
        'success_rate',
        'related_products',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'related_products' => 'array',
        'is_active' => 'boolean',
        'times_used' => 'integer',
        'times_successful' => 'integer',
        'success_rate' => 'decimal:2',
    ];

    /**
     * Registrar uso
     */
    public function recordUsage(bool $successful = true): void
    {
        $this->increment('times_used');
        
        if ($successful) {
            $this->increment('times_successful');
        }

        $this->update([
            'success_rate' => ($this->times_successful / $this->times_used) * 100
        ]);
    }

    /**
     * Buscar conhecimento ativo
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Buscar por categoria
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Mais usados
     */
    public function scopePopular($query)
    {
        return $query->orderByDesc('times_used');
    }
}
