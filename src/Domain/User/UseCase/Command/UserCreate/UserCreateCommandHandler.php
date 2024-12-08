<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Command\UserCreate;

use App\Domain\User\Services\UserCheckExistsService;
use App\Domain\User\Services\UserCreateService;
use App\Domain\User\Services\UserDataService;
use App\Domain\User\Services\UserValidationService;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UserCreateCommandHandler
{
    public function __construct(
        private UserCreateService $userCreateService,
        private UserValidationService $userValidationService,
        private UserCheckExistsService $userCheckExistsService,
    ) {
    }

    public function __invoke(UserCreateCommand $command): UserDataService
    {
        $userDataService = (new UserDataService())
            ->setCreateUserCommand($command);

        (new Pipeline())
            ->pipe($this->userValidationService)
            ->pipe($this->userCheckExistsService)
            ->pipe($this->userCreateService)
            ->process($userDataService);

        return $userDataService;
    }
}
