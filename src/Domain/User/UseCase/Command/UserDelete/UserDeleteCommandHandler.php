<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Command\UserDelete;

use App\Domain\User\Services\UserCheckNotExistsService;
use App\Domain\User\Services\UserDataService;
use App\Domain\User\Services\UserDeleteService;
use App\Domain\User\Services\UserRetrieveService;
use App\Domain\User\UseCase\Query\UserRetrieve\UserRetrieveQuery;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserDeleteCommandHandler
{
    public function __construct(
        private UserRetrieveService $userRetrieveService,
        private UserCheckNotExistsService $userCheckNotExistsService,
        private UserDeleteService $userDeleteService,
    ) {
    }

    public function __invoke(UserDeleteCommand $userDeleteCommand)
    {
        $userDataService = (new UserDataService())
            ->setUserDeleteCommand($userDeleteCommand)
            ->setRetrieveUserQuery(new UserRetrieveQuery($userDeleteCommand->getUserId()));

        (new Pipeline())
            ->pipe($this->userRetrieveService)
            ->pipe($this->userCheckNotExistsService)
            ->pipe($this->userDeleteService)
            ->process($userDataService);
    }
}
