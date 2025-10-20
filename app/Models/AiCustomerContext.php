<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiCustomerContext extends Model
{
    protected $table = 'ai_customer_context';

    protected $fillable = [
        'customer_identifier',
        'customer_name',
        'preferred_platform',
        'platforms',
        'interests',
        'purchase_history',
        'conversation_summary',
        'total_conversations',
        'total_purchases',
        'total_spent',
        'customer_segment',
        'last_interaction_at',
    ];

    protected $casts = [
        'platforms' => 'array',
        'interests' => 'array',
        'purchase_history' => 'array',
        'conversation_summary' => 'array',
        'total_conversations' => 'integer',
        'total_purchases' => 'integer',
        'total_spent' => 'decimal:2',
        'last_interaction_at' => 'datetime',
    ];

    /**
     * Atualizar contexto após interação
     */
    public function recordInteraction(string $platform, array $data = []): void
    {
        $this->increment('total_conversations');
        
        // Adicionar plataforma se não existir
        $platforms = $this->platforms ?? [];
        if (!in_array($platform, $platforms)) {
            $platforms[] = $platform;
            $this->platforms = $platforms;
        }

        $this->update([
            'last_interaction_at' => now(),
            'preferred_platform' => $platform,
        ]);

        // Adicionar dados extras
        if (isset($data['interests'])) {
            $this->addInterests($data['interests']);
        }
    }

    /**
     * Adicionar interesses
     */
    public function addInterests(array $interests): void
    {
        $current = $this->interests ?? [];
        $updated = array_unique(array_merge($current, $interests));
        $this->update(['interests' => $updated]);
    }

    /**
     * Registrar compra
     */
    public function recordPurchase(float $value, array $products = []): void
    {
        $this->increment('total_purchases');
        $this->increment('total_spent', $value);

        // Atualizar histórico
        $history = $this->purchase_history ?? [];
        $history[] = [
            'date' => now()->toDateString(),
            'value' => $value,
            'products' => $products,
        ];
        
        $this->update([
            'purchase_history' => $history,
            'customer_segment' => $this->calculateSegment(),
        ]);
    }

    /**
     * Calcular segmento do cliente
     */
    private function calculateSegment(): string
    {
        if ($this->total_spent > 5000000) {
            return 'vip';
        }

        if ($this->total_purchases >= 5) {
            return 'regular';
        }

        if ($this->total_conversations > 0 && $this->total_purchases == 0) {
            return 'at_risk';
        }

        return 'new';
    }
}
