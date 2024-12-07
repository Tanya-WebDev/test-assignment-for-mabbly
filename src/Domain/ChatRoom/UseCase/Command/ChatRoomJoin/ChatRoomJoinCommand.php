<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomJoin;

use App\Application\Bus\BaseCommand;
use App\Application\ValueObjects\UiidValueObject;
use App\Domain\User\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ChatRoomJoinCommand extends BaseCommand
{
    private UiidValueObject $chatRoomId;
    private User $user;

    public function __construct(
        string $chatRoomId,
        User $user,
    ) {
        $this->chatRoomId = new UiidValueObject($chatRoomId);
        $this->user = $user;
    }

    public static function fromRequest(Request $request, UserInterface|User $user): ChatRoomJoinCommand
    {
        return new self(
            (string) $request->get('id', 1),
            $user
        );
    }

    public function getChatRoomId(): string
    {
        return (string) $this->chatRoomId;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
