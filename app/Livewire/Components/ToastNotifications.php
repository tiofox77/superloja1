<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component;

class ToastNotifications extends Component
{
    public array $notifications = [];

    protected $listeners = [
        'show-toast' => 'addNotification'
    ];

    public function addNotification(array $data): void
    {
        $notification = [
            'id' => uniqid(),
            'type' => $data['type'] ?? 'info',
            'message' => $data['message'] ?? '',
            'duration' => $data['duration'] ?? 5000
        ];

        $this->notifications[] = $notification;

        // Auto remove after duration
        $this->dispatch('auto-remove-toast', ['id' => $notification['id'], 'duration' => $notification['duration']]);
    }

    public function removeNotification(string $id): void
    {
        $this->notifications = array_filter(
            $this->notifications, 
            fn($notification) => $notification['id'] !== $id
        );
    }

    public function render()
    {
        return view('livewire.components.toast-notifications');
    }
}
