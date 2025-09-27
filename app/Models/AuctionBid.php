<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuctionBid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'user_id',
        'bid_amount',
        'is_autobid',
        'is_buy_now',
        'max_bid_amount',
        'status',
        'ip_address',
        'notes',
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2',
        'max_bid_amount' => 'decimal:2',
        'is_autobid' => 'boolean',
        'is_buy_now' => 'boolean',
    ];

    /**
     * Get the auction that owns the bid.
     */
    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Get the user that owns the bid.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get only active bids.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get winning bids.
     */
    public function scopeWinning($query)
    {
        return $query->whereIn('status', ['winning', 'won']);
    }

    /**
     * Get bids by user.
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get highest bids first.
     */
    public function scopeHighestFirst($query)
    {
        return $query->orderBy('bid_amount', 'desc');
    }

    /**
     * Check if this is a winning bid.
     */
    public function isWinning(): bool
    {
        return in_array($this->status, ['winning', 'won']);
    }

    /**
     * Check if this is the highest bid for the auction.
     */
    public function isHighestBid(): bool
    {
        return $this->auction->current_bid == $this->bid_amount;
    }
}
