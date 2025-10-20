<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationDropdown extends Component
{
    public $notifications;
    public $unreadCount = 0;
    public $showDropdown = false;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        if (Auth::check()) {
            $this->notifications = NotificationService::getRecentForUser(Auth::id(), 10);
            $this->unreadCount = NotificationService::getUnreadCountForUser(Auth::id());
        } else {
            $this->notifications = collect();
            $this->unreadCount = 0;
        }
    }

    public function markAsRead($notificationId)
    {
        NotificationService::markAsRead($notificationId);
        $this->loadNotifications();
        $this->dispatch('notification-updated');
    }

    public function markAllAsRead()
    {
        if (Auth::check()) {
            NotificationService::markAllAsReadForUser(Auth::id());
            $this->loadNotifications();
            $this->dispatch('notification-updated');
        }
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    protected $listeners = ['notification-created' => 'loadNotifications'];

    public function render()
    {
        return view('livewire.notification-dropdown');
    }
}
