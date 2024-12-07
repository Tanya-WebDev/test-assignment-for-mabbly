<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Query\UserRetrieve;

use App\Domain\User\Entity\User;
use App\Domain\User\Services\UserCheckNotExistsService;
use App\Domain\User\Services\UserDataService;
use App\Domain\User\Services\UserRetrieveService;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserRetrieveQueryHandler
{
    public function __construct(
        private UserRetrieveService $retrieveService,
        private UserCheckNotExistsService $checkNotExistsService,
    ) {
    }

    public function __invoke(UserRetrieveQuery $userRetrieveQuery): ?User
    {
        $userDataService = (new UserDataService())
            ->setRetrieveUserQuery($userRetrieveQuery);

        (new Pipeline())
            ->pipe($this->retrieveService)
            ->pipe($this->checkNotExistsService)
            ->process($userDataService);

        return $userDataService->getUser();
    }
}
