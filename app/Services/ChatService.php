<?php

namespace App\Services;

use App\Repositories\Contracts\ChatRepositoryInterface;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Events\MessageSent;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class ChatService
{
    public function __construct(
        private ChatRepositoryInterface $chatRepository
    ) {}

    public function getUserRooms(int $userId, string $role): Collection
    {
        return $this->chatRepository->getUserRooms($userId, $role);
    }

    public function getRoomMessages(int $roomId, int $userId): Collection
    {
        $room = $this->chatRepository->getRoomById($roomId);
        $this->validateAccess($room, $userId);
        
        // Tandai pesan sebagai telah dibaca saat room dibuka
        $this->chatRepository->markRoomMessagesAsRead($roomId, $userId);
        
        return $this->chatRepository->getRoomMessages($roomId);
    }

    public function sendMessage(int $roomId, int $senderId, string $messageText): ChatMessage
    {
        $room = $this->chatRepository->getRoomById($roomId);
        $this->validateAccess($room, $senderId);

        // Sanitize input agar terhindar dari XSS (script injection)
        $cleanMessage = htmlspecialchars($messageText, ENT_QUOTES, 'UTF-8');

        $message = $this->chatRepository->createMessage($roomId, $senderId, $cleanMessage);
        $this->chatRepository->updateRoomLastMessage($roomId);

        $message->load('sender');

        // Pancarkan event broadcast untuk real-time (Tahap 9)
        // broadcast(new MessageSent($message))->toOthers();
        broadcast(new MessageSent($message));

        return $message;
    }

    public function initiateRoom(int $buyerId, int $sellerId, int $facilityId): ChatRoom
    {
        return $this->chatRepository->findOrCreateRoom($buyerId, $sellerId, $facilityId);
    }

    public function getUnreadCount(int $userId, string $role): int
    {
        return $this->chatRepository->getUnreadCount($userId, $role);
    }

    private function validateAccess(?ChatRoom $room, int $userId): void
    {
        if (!$room) {
            throw new Exception('Room percakapan tidak ditemukan.');
        }

        // Kunci ganda: Hanya pembeli dan penjual di room ini yang boleh akses
        if ($room->buyer_id !== $userId && $room->seller_id !== $userId) {
            throw new Exception('Akses ditolak! Anda tidak memiliki izin untuk melihat percakapan ini.');
        }
    }
}