<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
        'related_id',
        'related_type',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    public function getRelatedModel()
    {
        if ($this->related_type && $this->related_id) {
            return $this->related_type::find($this->related_id);
        }
        return null;
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Notification types
    const TYPE_ORDER_STATUS = 'order_status';
    const TYPE_AUCTION_STATUS = 'auction_status';
    const TYPE_PRODUCT_REQUEST = 'product_request';
    const TYPE_PRODUCT_REQUEST_STATUS = 'product_request_status';
    const TYPE_ADMIN_NEW_ORDER = 'admin_new_order';
    const TYPE_ADMIN_NEW_AUCTION = 'admin_new_auction';
    const TYPE_ADMIN_NEW_PRODUCT_REQUEST = 'admin_new_product_request';

    public static function getTypeLabels(): array
    {
        return [
            self::TYPE_ORDER_STATUS => 'Status do Pedido',
            self::TYPE_AUCTION_STATUS => 'Status do Leilão',
            self::TYPE_PRODUCT_REQUEST => 'Solicitação de Produto',
            self::TYPE_PRODUCT_REQUEST_STATUS => 'Status da Solicitação',
            self::TYPE_ADMIN_NEW_ORDER => 'Novo Pedido (Admin)',
            self::TYPE_ADMIN_NEW_AUCTION => 'Novo Leilão (Admin)',
            self::TYPE_ADMIN_NEW_PRODUCT_REQUEST => 'Nova Solicitação (Admin)',
        ];
    }

    public function getTypeLabel(): string
    {
        return self::getTypeLabels()[$this->type] ?? $this->type;
    }
}
