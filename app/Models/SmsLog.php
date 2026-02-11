<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SmsLog extends Model
{
    protected $fillable = [
        'phone',
        'message',
        'status',
        'provider',
        'response',
        'error',
        'message_id',
        'cost',
        'user_id',
        'type',
        'template_id',
    ];
    
    protected $casts = [
        'cost' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function template(): BelongsTo
    {
        return $this->belongsTo(SmsTemplate::class);
    }
    
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }
    
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
    
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
