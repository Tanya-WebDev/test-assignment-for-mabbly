<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class UserRetrieveService implements StageContract
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function handle(string $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /**
     * @param UserDataService $traveler
     */
    public function __invoke($traveler): UserDataService
    {
        $user = $this->handle($traveler->getRetrieveUserQuery()->getUserId());

        $traveler->setUser($user);

        return $traveler;
    }
}
