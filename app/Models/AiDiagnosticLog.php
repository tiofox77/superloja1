<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiDiagnosticLog extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_identifier',
        'issue_type',
        'customer_message',
        'ai_response',
        'context_data',
        'severity',
        'resolved',
        'admin_notes',
        'resolved_at',
    ];

    protected $casts = [
        'context_data' => 'array',
        'resolved' => 'boolean',
        'resolved_at' => 'datetime',
    ];

    /**
     * Relacionamento com contexto do cliente
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(AiCustomerContext::class, 'customer_id');
    }

    /**
     * Marcar como resolvido
     */
    public function markResolved(string $notes = null): void
    {
        $this->update([
            'resolved' => true,
            'resolved_at' => now(),
            'admin_notes' => $notes,
        ]);
    }

    /**
     * Scopes
     */
    public function scopeUnresolved($query)
    {
        return $query->where('resolved', false);
    }

    public function scopeHighSeverity($query)
    {
        return $query->where('severity', 'high');
    }

    public function scopeByIssueType($query, string $type)
    {
        return $query->where('issue_type', $type);
    }
}
