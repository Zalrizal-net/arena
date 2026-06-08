<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Services\ChatService;
use Illuminate\Support\Facades\Auth;

class ChatRoom extends Component
{
    public $roomId;
    public $messageText = '';
    
    // Hapus public $chatMessages agar payload Livewire tidak kelebihan beban

    public function mount($room)
    {
        // Konversi tegas ke (int) untuk memastikan tipe datanya aman
        $this->roomId = (int) (is_object($room) ? $room->id : $room);
    }

    public function refreshMessages()
    {
        // Fungsi ini dipanggil oleh Javascript saat ada pesan realtime masuk.
        // Dibiarkan kosong karena setiap kali Livewire memanggil fungsi apapun, 
        // ia akan otomatis menjalankan ulang fungsi render() di bawah ini untuk mengambil pesan terbaru.
    }

    public function sendMessage(ChatService $chatService)
    {
        $this->validate([
            'messageText' => 'required|string|max:1000'
        ]);

        $chatService->sendMessage($this->roomId, Auth::id(), $this->messageText);
        
        $this->messageText = ''; 
    }

    public function render(ChatService $chatService)
    {
        // Panggil data langsung di dalam render lalu lempar ke Blade
        // Cara ini mencegah memori Livewire bocor dan variabel lain menjadi null
        $messages = $chatService->getRoomMessages($this->roomId, Auth::id());

        return view('livewire.chat.chat-room', [
            'chatMessages' => $messages
        ])->layout('layouts.app');
    }
}