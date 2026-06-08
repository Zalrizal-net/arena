<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\ChatRoom;

Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    $room = ChatRoom::find($roomId);
    
    if ($room) {
        // Hanya izinkan user masuk channel JIKA dia adalah buyer atau seller di room tersebut
        return (int) $user->id === (int) $room->buyer_id || (int) $user->id === (int) $room->seller_id;
    }
    
    return false;
});