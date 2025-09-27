<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'product_name',
        'description',
        'brand',
        'model',
        'budget_min',
        'budget_max',
        'urgency',
        'condition_preference',
        'images',
        'status',
        'admin_notes',
        'matched_product_id',
        'expires_at',
    ];

    protected $casts = [
        'images' => 'array',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function matchedProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'matched_product_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'in_progress']);
    }

    public function scopeUrgent($query)
    {
        return $query->where('urgency', 'high');
    }

    public function getUrgencyColorAttribute(): string
    {
        return match($this->urgency) {
            'high' => 'red',
            'medium' => 'yellow',
            'low' => 'green',
            default => 'gray'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'in_progress' => 'blue',
            'matched' => 'green',
            'closed' => 'gray',
            default => 'gray'
        };
    }
}
