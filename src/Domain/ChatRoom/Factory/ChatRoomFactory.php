<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Factory;

use App\Domain\ChatRoom\Entity\ChatRoom;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomCreate\ChatRoomCreateCommand;

class ChatRoomFactory
{
    public static function fromCreateCommand(ChatRoomCreateCommand $chatRoomCreateCommand): ChatRoom
    {
        return (new ChatRoom())
            ->setTitle($chatRoomCreateCommand->getTitle())
            ->setDescription($chatRoomCreateCommand->getDescription())
            ->setPublic($chatRoomCreateCommand->isPublic())
            ->setOwner($chatRoomCreateCommand->getOwner());
    }

    public static function convertChatRoomToArray(ChatRoom $chatRoom): array
    {
        return [
            'id' => $chatRoom->getId(),
            'owner_id' => $chatRoom->getOwner()->getId(),
            'title' => $chatRoom->getTitle(),
            'description' => $chatRoom->getDescription(),
            'public' => $chatRoom->isPublic(),
            'created_at' => $chatRoom->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
