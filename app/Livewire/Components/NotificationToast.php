<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;

class NotificationToast extends Component
{
    public array $notifications = [];

    protected $listeners = [
        'show-notification' => 'addNotification'
    ];

    public function addNotification($message, $type = 'success'): void
    {
        $id = uniqid();
        $this->notifications[] = [
            'id' => $id,
            'message' => $message,
            'type' => $type,
            'timestamp' => now()
        ];

        // Usar setTimeout no JavaScript para auto-remover
        $this->dispatch('set-auto-remove', id: $id);
    }

    public function removeNotification($id): void
    {
        $this->notifications = array_filter(
            $this->notifications,
            fn($notification) => $notification['id'] !== $id
        );
    }

    public function render()
    {
        return view('livewire.components.notification-toast');
    }
}
