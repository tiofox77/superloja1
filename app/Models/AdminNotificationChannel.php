<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotificationChannel extends Model
{
    protected $fillable = [
        'user_id',
        'email_enabled',
        'sms_enabled',
        'facebook_messenger_enabled',
        'instagram_enabled',
        'browser_enabled',
        'email',
        'phone',
        'facebook_messenger_id',
        'instagram_id',
        'notification_types',
        'urgent_only',
        'quiet_hours',
    ];

    protected $casts = [
        'email_enabled' => 'boolean',
        'sms_enabled' => 'boolean',
        'facebook_messenger_enabled' => 'boolean',
        'instagram_enabled' => 'boolean',
        'browser_enabled' => 'boolean',
        'urgent_only' => 'boolean',
        'notification_types' => 'array',
        'quiet_hours' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verificar se está em horário de silêncio
     */
    public function isQuietHour(): bool
    {
        if (!$this->quiet_hours) {
            return false;
        }

        $currentHour = now()->hour;
        $start = $this->quiet_hours['start'] ?? null;
        $end = $this->quiet_hours['end'] ?? null;

        if ($start === null || $end === null) {
            return false;
        }

        // Ex: 22h às 8h (passa meia-noite)
        if ($start > $end) {
            return $currentHour >= $start || $currentHour < $end;
        }

        // Ex: 22h às 23h (mesmo dia)
        return $currentHour >= $start && $currentHour < $end;
    }

    /**
     * Deve receber notificação?
     */
    public function shouldReceive(string $type, bool $isUrgent = false): bool
    {
        // Se só quer urgentes e não é urgente
        if ($this->urgent_only && !$isUrgent) {
            return false;
        }

        // Se está em horário de silêncio (exceto urgentes)
        if (!$isUrgent && $this->isQuietHour()) {
            return false;
        }

        // Se tem filtro de tipos específicos
        if ($this->notification_types && !empty($this->notification_types)) {
            return in_array($type, $this->notification_types);
        }

        return true;
    }

    /**
     * Obter ou criar configuração para um usuário
     */
    public static function getForUser(int $userId): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId],
            [
                'email_enabled' => true,
                'browser_enabled' => true,
            ]
        );
    }
}
