<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiAgentAction extends Model
{
    protected $fillable = [
        'action_type',
        'description',
        'context',
        'result',
        'status',
        'requires_approval',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'context' => 'array',
        'result' => 'array',
        'requires_approval' => 'boolean',
        'approved_at' => 'datetime',
    ];

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Ações pendentes de aprovação
     */
    public function scopePendingApproval($query)
    {
        return $query->where('requires_approval', true)
                    ->whereNull('approved_at');
    }

    /**
     * Aprovar ação
     */
    public function approve(User $user): bool
    {
        return $this->update([
            'approved_by' => $user->id,
            'approved_at' => now(),
            'status' => 'executed',
        ]);
    }
}
