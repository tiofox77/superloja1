<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\AdminNotificationChannel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MultiChannelNotificationService
{
    /**
     * Enviar notificação para admin por múltiplos canais
     */
    public static function sendToAdmin(
        int $userId,
        string $type,
        string $title,
        string $message,
        bool $isUrgent = false,
        array $data = []
    ): void {
        $config = AdminNotificationChannel::getForUser($userId);
        $user = User::find($userId);

        if (!$user) {
            return;
        }

        // Verificar se deve receber
        if (!$config->shouldReceive($type, $isUrgent)) {
            Log::info('Notificação bloqueada por filtros', [
                'user_id' => $userId,
                'type' => $type,
                'urgent' => $isUrgent,
            ]);
            return;
        }

        $channels = [];

        // 1. Notificação no Browser (Painel)
        if ($config->browser_enabled) {
            self::sendBrowser($userId, $type, $title, $message, $data);
            $channels[] = 'browser';
        }

        // 2. Email
        if ($config->email_enabled && $config->email) {
            self::sendEmail($config->email, $title, $message);
            $channels[] = 'email';
        }

        // 3. SMS
        if ($config->sms_enabled && $config->phone) {
            self::sendSMS($config->phone, $title, $message);
            $channels[] = 'sms';
        }

        // 4. Facebook Messenger
        if ($config->facebook_messenger_enabled && $config->facebook_messenger_id) {
            self::sendFacebookMessenger($config->facebook_messenger_id, $title, $message);
            $channels[] = 'messenger';
        }

        // 5. Instagram
        if ($config->instagram_enabled && $config->instagram_id) {
            self::sendInstagram($config->instagram_id, $title, $message);
            $channels[] = 'instagram';
        }

        Log::info('Notificação multi-canal enviada', [
            'user_id' => $userId,
            'type' => $type,
            'channels' => $channels,
            'urgent' => $isUrgent,
        ]);
    }

    /**
     * Notificação no Browser (Sistema atual)
     */
    private static function sendBrowser(int $userId, string $type, string $title, string $message, array $data): void
    {
        NotificationService::create(
            $userId,
            $type,
            $title,
            $message,
            $data
        );
    }

    /**
     * Enviar Email
     */
    private static function sendEmail(string $email, string $title, string $message): void
    {
        try {
            Mail::raw($message, function ($mail) use ($email, $title) {
                $mail->to($email)
                     ->subject("🔔 {$title}");
            });

            Log::info('Email enviado', ['to' => $email]);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar email', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Enviar SMS usando SmsService (Unimtx)
     */
    private static function sendSMS(string $phone, string $title, string $message): void
    {
        try {
            $smsService = app(\App\Services\SmsService::class);
            
            // Mensagem formatada para SMS
            $smsMessage = "{$title}\n\n{$message}";
            
            // Enviar usando serviço Unimtx existente
            $sent = $smsService->sendSms($phone, $smsMessage);
            
            if ($sent) {
                Log::info('SMS enviado via Unimtx', [
                    'to' => $phone,
                    'title' => $title
                ]);
            } else {
                Log::warning('Falha ao enviar SMS via Unimtx', [
                    'to' => $phone,
                    'title' => $title
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar SMS', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Enviar via Facebook Messenger
     */
    private static function sendFacebookMessenger(string $messengerId, string $title, string $message): void
    {
        try {
            $socialMedia = app(SocialMediaAgentService::class);
            
            $fullMessage = "🔔 *{$title}*\n\n{$message}";
            
            $sent = $socialMedia->sendMessengerMessage($messengerId, $fullMessage);
            
            if ($sent) {
                Log::info('Messenger enviado', ['to' => $messengerId]);
            } else {
                Log::warning('Falha ao enviar Messenger', ['to' => $messengerId]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar Messenger', [
                'messenger_id' => $messengerId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Enviar via Instagram
     */
    private static function sendInstagram(string $instagramId, string $title, string $message): void
    {
        try {
            $socialMedia = app(SocialMediaAgentService::class);
            
            $fullMessage = "🔔 *{$title}*\n\n{$message}";
            
            $sent = $socialMedia->sendInstagramMessage($instagramId, $fullMessage);
            
            if ($sent) {
                Log::info('Instagram enviado', ['to' => $instagramId]);
            } else {
                Log::warning('Falha ao enviar Instagram', ['to' => $instagramId]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar Instagram', [
                'instagram_id' => $instagramId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Enviar para TODOS os admins
     */
    public static function sendToAllAdmins(
        string $type,
        string $title,
        string $message,
        bool $isUrgent = false,
        array $data = []
    ): void {
        $adminUsers = User::where('is_admin', true)->get();

        foreach ($adminUsers as $admin) {
            self::sendToAdmin(
                $admin->id,
                $type,
                $title,
                $message,
                $isUrgent,
                $data
            );
        }
    }
}
