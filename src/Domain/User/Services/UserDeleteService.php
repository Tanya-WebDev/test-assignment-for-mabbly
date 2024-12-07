<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Repository\UserRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class UserDeleteService implements StageContract
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function handle(UserDataService $dataService): UserDataService
    {
        $this->userRepository->delete($dataService->getUser());
        $dataService->setUser(null);

        return $dataService;
    }

    /**
     * @param UserDataService $traveler
     */
    public function __invoke($traveler): UserDataService
    {
        return $this->handle($traveler);
    }
}
