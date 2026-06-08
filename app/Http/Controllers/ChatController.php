<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Services\ChatService;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function startChat(Facility $facility, ChatService $chatService)
    {
        // Cegah seller chat ke fasilitas miliknya sendiri
        if (Auth::user()->role === 'seller' && $facility->seller_id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa memulai chat di fasilitas Anda sendiri.');
        }

        $buyerId = Auth::id();
        
        
        $sellerId = $facility->seller_id; 

        // Panggil service untuk mencari room lama atau membuat room baru
        $room = $chatService->initiateRoom($buyerId, $sellerId, $facility->id);

        return redirect()->route('chat.room', $room->id);
    }
}