<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomDelete;

use App\Application\Bus\BaseCommand;
use App\Application\ValueObjects\UiidValueObject;
use Symfony\Component\HttpFoundation\Request;

class ChatRoomDeleteCommand extends BaseCommand
{
    private UiidValueObject $chatRoomId;

    public function __construct(string $chatRoomId)
    {
        $this->chatRoomId = new UiidValueObject($chatRoomId);
    }

    public static function fromRequest(Request $request): ChatRoomDeleteCommand
    {
        return new self((string) $request->get('id', 1));
    }

    public function getChatRoomId(): string
    {
        return (string) $this->chatRoomId;
    }
}
