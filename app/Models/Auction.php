<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'seller_id',
        'title',
        'description',
        'starting_price',
        'current_bid',
        'reserve_price',
        'buy_now_price',
        'start_time',
        'end_time',
        'status',
        'auto_extend',
        'extend_minutes',
        'bid_count',
        'view_count',
        'watcher_count',
        'winner_id',
        'won_at',
        'bid_increment',
        'max_bid_count',
        'private_auction',
    ];

    protected $casts = [
        'starting_price' => 'decimal:2',
        'reserve_price' => 'decimal:2',
        'current_bid' => 'decimal:2',
        'buy_now_price' => 'decimal:2',
        'winning_bid' => 'decimal:2',
        'bid_increment' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'won_at' => 'datetime',
        'auto_extend' => 'boolean',
        'private_auction' => 'boolean',
        'duration_minutes' => 'integer',
        'extend_minutes' => 'integer',
        'bid_count' => 'integer',
        'view_count' => 'integer',
        'watcher_count' => 'integer',
        'max_bid_count' => 'integer',
    ];

    /**
     * Get the product that belongs to the auction.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Seller relationship (deprecated - seller is always auth user)
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the winner of the auction.
     */
    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    /**
     * Get the bids for the auction.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(AuctionBid::class)->orderBy('bid_amount', 'desc');
    }

    /**
     * Get the highest bid.
     */
    public function highestBid(): ?AuctionBid
    {
        return $this->bids()->orderBy('bid_amount', 'desc')->first();
    }

    /**
     * Get only active auctions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>', now());
    }

    /**
     * Get only ended auctions.
     */
    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    /**
     * Get auctions ending soon.
     */
    public function scopeEndingSoon($query, int $hours = 24)
    {
        return $query->where('status', 'active')
                    ->where('end_time', '>', now())
                    ->where('end_time', '<=', now()->addHours($hours));
    }

    /**
     * Check if auction is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' 
            && $this->start_time <= now() 
            && $this->end_time > now();
    }

    /**
     * Check if auction has ended.
     */
    public function hasEnded(): bool
    {
        return $this->end_time <= now() || $this->status === 'ended';
    }

    /**
     * Check if auction has reserve price met.
     */
    public function hasReserveMet(): bool
    {
        if (!$this->reserve_price) {
            return true;
        }

        return $this->current_bid >= $this->reserve_price;
    }

    /**
     * Get time remaining.
     */
    public function getTimeRemainingAttribute(): ?string
    {
        if ($this->hasEnded()) {
            return null;
        }

        $now = Carbon::now();
        $endTime = Carbon::parse($this->end_time);
        
        return $endTime->diffForHumans($now, true);
    }

    /**
     * Get next minimum bid amount.
     */
    public function getNextMinBidAttribute(): float
    {
        return $this->current_bid + $this->bid_increment;
    }

    /**
     * Place a bid on this auction.
     */
    public function placeBid(User $user, float $amount, bool $isAutoBid = false, ?float $maxBid = null): AuctionBid
    {
        $bid = $this->bids()->create([
            'user_id' => $user->id,
            'bid_amount' => $amount,
            'is_autobid' => $isAutoBid,
            'max_bid_amount' => $maxBid,
            'ip_address' => request()->ip(),
        ]);

        // Update auction current bid and bid count
        $this->update([
            'current_bid' => $amount,
            'bid_count' => $this->bid_count + 1,
        ]);

        // Auto-extend if enabled and bid is within extend time
        if ($this->auto_extend && $this->end_time->diffInMinutes(now()) <= $this->extend_minutes) {
            $this->update([
                'end_time' => $this->end_time->addMinutes($this->extend_minutes)
            ]);
        }

        return $bid;
    }

    /**
     * End the auction and determine winner.
     */
    public function endAuction(): void
    {
        $highestBid = $this->highestBid();
        
        $updateData = [
            'status' => 'ended',
            'end_time' => now(),
        ];

        if ($highestBid && $this->hasReserveMet()) {
            $updateData['winner_id'] = $highestBid->user_id;
            $updateData['winning_bid'] = $highestBid->bid_amount;
            $updateData['won_at'] = now();
            $updateData['status'] = 'sold';
        }

        $this->update($updateData);
    }
}
