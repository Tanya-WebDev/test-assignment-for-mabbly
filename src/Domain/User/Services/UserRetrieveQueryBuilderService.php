<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;
use Rockett\Pipeline\Contracts\StageContract;

readonly class UserRetrieveQueryBuilderService implements StageContract
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function handle(): QueryBuilder
    {
        return $this->userRepository->createQueryBuilder('u');
    }

    public function __invoke($traveler): QueryBuilder
    {
        return $this->handle();
    }
}
