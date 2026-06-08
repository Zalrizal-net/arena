<?php

namespace App\Http\Livewire\Buyer;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class NotificationList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
    }

    public function deleteNotification($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->delete();
        }
    }

    public function render()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        
        return view('livewire.buyer.notification-list', [
            'notifications' => $notifications
        ])->layout('layouts.app'); 
    }
}