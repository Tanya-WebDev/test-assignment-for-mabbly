<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Query\UserChatRoomsList;

use App\Application\Doctrine\QueryBuilder\PaginationService;
use App\Domain\User\Services\UserChatRoomsListQueryBuilderService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserChatRoomsListQueryHandler
{
    public function __construct(
        private UserChatRoomsListQueryBuilderService $chatRoomsListQueryBuilderService,
    ) {
    }

    public function __invoke(UserChatRoomsListQuery $chatRoomsListQuery): array
    {
        $usersQueryBuilder = $this->chatRoomsListQueryBuilderService->handle($chatRoomsListQuery->getUserId());

        return PaginationService::paginate(
            $usersQueryBuilder,
            $chatRoomsListQuery->getPage(),
        );
    }
}
