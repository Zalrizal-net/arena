<?php

namespace App\Repositories;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Repositories\Contracts\ChatRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class ChatRepository implements ChatRepositoryInterface
{
    public function getUserRooms(int $userId, string $role): Collection
    {
        $column = $role === 'seller' ? 'seller_id' : 'buyer_id';
        
        return ChatRoom::with(['buyer', 'seller', 'facility', 'latestMessage'])
            ->where($column, $userId)
            ->orderByDesc('last_message_at')
            ->get();
    }

    public function getRoomById(int $roomId): ?ChatRoom
    {
        return ChatRoom::with(['buyer', 'seller', 'facility'])->find($roomId);
    }

    public function findOrCreateRoom(int $buyerId, int $sellerId, int $facilityId): ChatRoom
    {
        // Akan mengembalikan room lama jika sudah ada, atau membuat baru jika belum ada
        return ChatRoom::firstOrCreate([
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
            'facility_id' => $facilityId,
        ]);
    }

    public function getRoomMessages(int $roomId): Collection
    {
        return ChatMessage::with('sender')
            ->where('room_id', $roomId)
            ->oldest() // Pesan lama di atas, pesan baru di bawah
            ->get();
    }

    public function createMessage(int $roomId, int $senderId, string $message): ChatMessage
    {
        return ChatMessage::create([
            'room_id' => $roomId,
            'sender_id' => $senderId,
            'message' => $message,
            'is_read' => false,
        ]);
    }

    public function updateRoomLastMessage(int $roomId): void
    {
        ChatRoom::where('id', $roomId)->update([
            'last_message_at' => Carbon::now()
        ]);
    }

    public function markRoomMessagesAsRead(int $roomId, int $userId): void
    {
        // Ubah is_read jadi true untuk pesan yang DITERIMA user ini (bukan pesan yang dia kirim)
        ChatMessage::where('room_id', $roomId)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function getUnreadCount(int $userId, string $role): int
    {
        $roomColumn = $role === 'seller' ? 'seller_id' : 'buyer_id';
        
        return ChatMessage::whereHas('room', function($query) use ($userId, $roomColumn) {
            $query->where($roomColumn, $userId);
        })
        ->where('sender_id', '!=', $userId)
        ->where('is_read', false)
        ->count();
    }
}