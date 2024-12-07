<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Query\UsersList;

use App\Application\Doctrine\QueryBuilder\PaginationService;
use App\Domain\User\Services\UserRetrieveQueryBuilderService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserListQueryHandler
{
    public function __construct(
        private UserRetrieveQueryBuilderService $userListService,
    ) {
    }

    public function __invoke(UserListQuery $listQuery): array
    {
        $usersQueryBuilder = $this->userListService->handle();

        return PaginationService::paginate(
            $usersQueryBuilder,
            $listQuery->getPage(),
        );
    }
}
