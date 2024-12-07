<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Query\ChatRoomListUsers;

use App\Application\Bus\BaseQuery;
use App\Application\ValueObjects\UiidValueObject;
use Symfony\Component\HttpFoundation\Request;

class ChatRoomListUsersQuery extends BaseQuery
{
    private int $page;
    private UiidValueObject $chatRoomId;

    public function __construct(
        int $page,
        string $chatRoomId,
    ) {
        $this->page = $page;
        $this->chatRoomId = new UiidValueObject($chatRoomId);
    }

    public static function fromRequest(Request $request): ChatRoomListUsersQuery
    {
        return new self(
            (int) $request->get('page', 1),
            (string) $request->get('id'),
        );
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getChatRoomId(): string
    {
        return (string) $this->chatRoomId;
    }
}
