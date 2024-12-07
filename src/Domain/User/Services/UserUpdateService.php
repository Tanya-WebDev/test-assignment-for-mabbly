<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Repository\UserRepository;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserUpdateService implements StageContract
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository,
    ) {
    }

    public function handle(UserDataService $dataService): UserDataService
    {
        $user = $dataService->getUser();

        $user->setFirstName($dataService->getUserUpdateCommand()->getFirstName());
        $user->setLastName($dataService->getUserUpdateCommand()->getLastName());
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $dataService->getUserUpdateCommand()->getPassword()));

        $this->userRepository->save($user);

        $dataService->setUser($user);

        return $dataService;
    }

    /**
     * @param UserDataService $traveler
     */
    public function __invoke($traveler): UserDataService
    {
        $this->handle($traveler);

        return $traveler;
    }
}
