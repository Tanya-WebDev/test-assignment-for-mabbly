<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve;

use App\Application\Bus\BaseQuery;
use App\Application\ValueObjects\UiidValueObject;
use Symfony\Component\HttpFoundation\Request;

class ChatRoomRetrieveQuery extends BaseQuery
{
    private UiidValueObject $chatRoomId;

    public function __construct(string $chatRoom)
    {
        $this->chatRoomId = new UiidValueObject($chatRoom);
    }

    public static function fromRequest(Request $request): ChatRoomRetrieveQuery
    {
        return new self(
            (string) $request->get('id', 1),
        );
    }

    public function getChatRoomId(): string
    {
        return (string) $this->chatRoomId;
    }
}
