<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Services\ChatService;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $rooms;
    public $role;

    public function mount(ChatService $chatService)
    {
        $user = Auth::user();
        $this->role = $user->role;
        // Mengambil daftar room dari database (diurutkan dari pesan terbaru)
        $this->rooms = $chatService->getUserRooms($user->id, $this->role);
    }

    public function render()
    {
        return view('livewire.chat.chat-list')->layout('layouts.app');
    }
}