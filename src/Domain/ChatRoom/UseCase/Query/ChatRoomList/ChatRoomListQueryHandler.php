<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Query\ChatRoomList;

use App\Application\Doctrine\QueryBuilder\PaginationService;
use App\Domain\ChatRoom\Services\ChatRoomRetrieveQueryBuilderService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomListQueryHandler
{
    public function __construct(
        private ChatRoomRetrieveQueryBuilderService $chatRoomRetrieveQueryBuilderService,
    ) {
    }

    public function __invoke(ChatRoomListQuery $chatRoomListQuery): array
    {
        $usersQueryBuilder = $this->chatRoomRetrieveQueryBuilderService->handle();

        return PaginationService::paginate(
            $usersQueryBuilder,
            $chatRoomListQuery->getPage(),
        );
    }
}
