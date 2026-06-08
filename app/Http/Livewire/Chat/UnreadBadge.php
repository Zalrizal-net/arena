<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Services\ChatService;
use Illuminate\Support\Facades\Auth;

class UnreadBadge extends Component
{
    public $unreadCount = 0;
    public $role;

    public function mount(ChatService $chatService)
    {
        if (Auth::check()) {
            $this->role = Auth::user()->role;
            $this->updateCount($chatService);
        }
    }

    public function updateCount(ChatService $chatService)
    {
        if (Auth::check()) {
            $this->unreadCount = $chatService->getUnreadCount(Auth::id(), $this->role);
        }
    }

    public function render()
    {
        return view('livewire.chat.unread-badge');
    }
}