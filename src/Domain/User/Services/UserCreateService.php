<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepository;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserCreateService implements StageContract
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function __invoke($traveler): UserDataService
    {
        return $this->handle($traveler);
    }

    public function handle(UserDataService $dataService): UserDataService
    {
        $user = UserFactory::fromCreateCommand($dataService->getCreateUserCommand());
        $user->setPassword($this->userPasswordHasher->hashPassword(
            $user,
            $dataService->getCreateUserCommand()->getPassword()
        ));

        $this->userRepository->save($user);
        $dataService->setUser($user);

        return $dataService;
    }
}
