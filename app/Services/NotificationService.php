<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create a notification for a user
     */
    public static function create(
        int $userId,
        string $type,
        string $title,
        string $message,
        array $data = [],
        int $relatedId = null,
        string $relatedType = null
    ): Notification {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'related_id' => $relatedId,
            'related_type' => $relatedType,
        ]);
    }

    /**
     * Create notifications for all admin users
     */
    public static function createForAdmins(
        string $type,
        string $title,
        string $message,
        array $data = [],
        int $relatedId = null,
        string $relatedType = null
    ): void {
        $adminUsers = User::where('is_admin', true)->get();

        Log::info('Criando notificações para admins', [
            'type' => $type,
            'total_admins' => $adminUsers->count(),
            'admin_ids' => $adminUsers->pluck('id')->toArray()
        ]);

        if ($adminUsers->isEmpty()) {
            Log::warning('Nenhum admin encontrado para notificar!');
            return;
        }

        foreach ($adminUsers as $admin) {
            $notification = self::create(
                $admin->id,
                $type,
                $title,
                $message,
                $data,
                $relatedId,
                $relatedType
            );
            
            Log::info('Notificação criada para admin', [
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
                'notification_id' => $notification->id
            ]);
        }
    }

    /**
     * Order Status Notifications
     */
    public static function orderStatusUpdated(int $userId, string $orderNumber, string $status, int $orderId = null): void
    {
        $statusMessages = [
            'pending' => 'Seu pedido foi recebido e está aguardando processamento.',
            'processing' => 'Seu pedido está sendo preparado.',
            'shipped' => 'Seu pedido foi enviado e está a caminho.',
            'delivered' => 'Seu pedido foi entregue com sucesso.',
            'cancelled' => 'Seu pedido foi cancelado.',
        ];

        $message = $statusMessages[$status] ?? "Status do pedido atualizado para: {$status}";

        self::create(
            $userId,
            Notification::TYPE_ORDER_STATUS,
            "Pedido #{$orderNumber} - {$status}",
            $message,
            ['order_number' => $orderNumber, 'status' => $status],
            $orderId,
            'App\Models\Order'
        );
    }

    /**
     * New Order Notification for Admins
     */
    public static function newOrderForAdmins(string $orderNumber, int $orderId, string $customerName): void
    {
        self::createForAdmins(
            Notification::TYPE_ADMIN_NEW_ORDER,
            "Novo Pedido #{$orderNumber}",
            "Um novo pedido foi realizado por {$customerName}.",
            [
                'order_number' => $orderNumber,
                'customer_name' => $customerName
            ],
            $orderId,
            'App\Models\Order'
        );
    }

    /**
     * Auction Status Notifications
     */
    public static function auctionStatusUpdated(int $userId, string $auctionTitle, string $status, int $auctionId = null): void
    {
        $statusMessages = [
            'active' => 'O leilão está ativo e você pode fazer lances.',
            'ended' => 'O leilão foi finalizado.',
            'won' => 'Parabéns! Você ganhou este leilão.',
            'lost' => 'Infelizmente você não ganhou este leilão.',
            'cancelled' => 'O leilão foi cancelado.',
        ];

        $message = $statusMessages[$status] ?? "Status do leilão atualizado para: {$status}";

        self::create(
            $userId,
            Notification::TYPE_AUCTION_STATUS,
            "Leilão: {$auctionTitle}",
            $message,
            ['auction_title' => $auctionTitle, 'status' => $status],
            $auctionId,
            'App\Models\Auction'
        );
    }

    /**
     * New Auction Notification for Admins
     */
    public static function newAuctionForAdmins(string $auctionTitle, int $auctionId, string $creatorName): void
    {
        self::createForAdmins(
            Notification::TYPE_ADMIN_NEW_AUCTION,
            "Novo Leilão: {$auctionTitle}",
            "Um novo leilão foi criado por {$creatorName}.",
            [
                'auction_title' => $auctionTitle,
                'creator_name' => $creatorName
            ],
            $auctionId,
            'App\Models\Auction'
        );
    }

    /**
     * Product Request Notifications
     */
    public static function productRequestSubmitted(int $userId, string $productName, int $requestId): void
    {
        self::create(
            $userId,
            Notification::TYPE_PRODUCT_REQUEST,
            "Solicitação de Produto Enviada",
            "Sua solicitação para o produto '{$productName}' foi enviada e está sendo analisada.",
            ['product_name' => $productName],
            $requestId,
            'App\Models\ProductRequest'
        );
    }

    /**
     * Product Request Status Update
     */
    public static function productRequestStatusUpdated(int $userId, string $productName, string $status, int $requestId): void
    {
        $statusMessages = [
            'pending' => 'Sua solicitação está aguardando análise.',
            'approved' => 'Sua solicitação foi aprovada! O produto será adicionado em breve.',
            'rejected' => 'Infelizmente sua solicitação foi rejeitada.',
            'completed' => 'Sua solicitação foi completada! O produto já está disponível na loja.',
        ];

        $message = $statusMessages[$status] ?? "Status da solicitação atualizado para: {$status}";

        self::create(
            $userId,
            Notification::TYPE_PRODUCT_REQUEST_STATUS,
            "Solicitação: {$productName}",
            $message,
            ['product_name' => $productName, 'status' => $status],
            $requestId,
            'App\Models\ProductRequest'
        );
    }

    /**
     * New Product Request for Admins
     */
    public static function newProductRequestForAdmins(string $productName, int $requestId, string $requesterName): void
    {
        self::createForAdmins(
            Notification::TYPE_ADMIN_NEW_PRODUCT_REQUEST,
            "Nova Solicitação de Produto",
            "Uma nova solicitação para '{$productName}' foi enviada por {$requesterName}.",
            [
                'product_name' => $productName,
                'requester_name' => $requesterName
            ],
            $requestId,
            'App\Models\ProductRequest'
        );
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead(int $notificationId): bool
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Mark all notifications as read for a user
     */
    public static function markAllAsReadForUser(int $userId): void
    {
        Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Get unread count for a user
     */
    public static function getUnreadCountForUser(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Get recent notifications for a user
     */
    public static function getRecentForUser(int $userId, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

}
