<?php

namespace App\Repositories\Contracts;

use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Collection;

interface ChatRepositoryInterface
{
    public function getUserRooms(int $userId, string $role): Collection;
    public function getRoomById(int $roomId): ?ChatRoom;
    public function findOrCreateRoom(int $buyerId, int $sellerId, int $facilityId): ChatRoom;
    public function getRoomMessages(int $roomId): Collection;
    public function createMessage(int $roomId, int $senderId, string $message): ChatMessage;
    public function updateRoomLastMessage(int $roomId): void;
    public function markRoomMessagesAsRead(int $roomId, int $userId): void;
    public function getUnreadCount(int $userId, string $role): int;
}