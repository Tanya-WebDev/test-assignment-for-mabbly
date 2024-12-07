<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Entity;

use App\Domain\User\Entity\User;
use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(
    name: 'chat_room_memberships',
    indexes: [
        new ORM\Index(name: 'user_id_chat_room_id_chat_room_memberships', columns: ['user_id', 'chat_room_id']),
    ],
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'unique_user_chat_room', columns: ['user_id', 'chat_room_id']),
    ],
)]
class ChatRoomMembership
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?string $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: ChatRoom::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ChatRoom $chatRoom;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $joinedAt;

    public function __construct()
    {
        $this->joinedAt = new DateTime();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getChatRoom(): ChatRoom
    {
        return $this->chatRoom;
    }

    public function setChatRoom(ChatRoom $chatRoom): self
    {
        $this->chatRoom = $chatRoom;

        return $this;
    }

    public function getJoinedAt(): DateTimeInterface
    {
        return $this->joinedAt;
    }

    public function setJoinedAt(DateTimeInterface $joinedAt): void
    {
        $this->joinedAt = $joinedAt;
    }
}
