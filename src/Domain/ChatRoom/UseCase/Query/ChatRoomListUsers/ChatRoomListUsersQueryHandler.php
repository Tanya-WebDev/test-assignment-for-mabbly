<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Query\ChatRoomListUsers;

use App\Application\Doctrine\QueryBuilder\PaginationService;
use App\Domain\ChatRoom\Services\ChatRoomListUsersQueryBuilderService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomListUsersQueryHandler
{
    public function __construct(
        private ChatRoomListUsersQueryBuilderService $chatRoomListUsersQueryBuilderService,
    ) {
    }

    public function __invoke(ChatRoomListUsersQuery $chatRoomListUsersQuery): array
    {
        $usersQueryBuilder = $this
            ->chatRoomListUsersQueryBuilderService
            ->handle($chatRoomListUsersQuery->getChatRoomId());

        return PaginationService::paginate(
            $usersQueryBuilder,
            $chatRoomListUsersQuery->getPage(),
        );
    }
}
