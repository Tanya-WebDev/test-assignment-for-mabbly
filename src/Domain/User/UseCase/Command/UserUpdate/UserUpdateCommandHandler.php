<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Command\UserUpdate;

use App\Domain\User\Services\UserCheckNotExistsService;
use App\Domain\User\Services\UserDataService;
use App\Domain\User\Services\UserRetrieveService;
use App\Domain\User\Services\UserUpdateService;
use App\Domain\User\Services\UserValidationService;
use App\Domain\User\UseCase\Query\UserRetrieve\UserRetrieveQuery;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserUpdateCommandHandler
{
    public function __construct(
        private UserValidationService $userValidationService,
        private UserCheckNotExistsService $userCheckNotExistsService,
        private UserRetrieveService $userRetrieveService,
        private UserUpdateService $userUpdateService,
    ) {
    }

    public function __invoke(UserUpdateCommand $userUpdateCommand): UserDataService
    {
        $userDataService = (new UserDataService())
            ->setUserUpdateCommand($userUpdateCommand)
            ->setRetrieveUserQuery(new UserRetrieveQuery($userUpdateCommand->getUserId()));

        (new Pipeline())
            ->pipe($this->userValidationService)
            ->pipe($this->userRetrieveService)
            ->pipe($this->userCheckNotExistsService)
            ->pipe($this->userUpdateService)
            ->process($userDataService);

        return $userDataService;
    }
}
