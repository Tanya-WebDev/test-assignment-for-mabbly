<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Query\UserChatRoomsList;

use App\Application\Bus\BaseQuery;
use App\Application\ValueObjects\UiidValueObject;
use Symfony\Component\HttpFoundation\Request;

class UserChatRoomsListQuery extends BaseQuery
{
    private int $page;
    private UiidValueObject $userId;

    public function __construct(
        int $page,
        string $userId,
    ) {
        $this->page = $page;
        $this->userId = new UiidValueObject($userId);
    }

    public static function fromRequest(Request $request): UserChatRoomsListQuery
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

    public function getUserId(): string
    {
        return (string) $this->userId;
    }
}
