<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Exceptions\UserValidateException;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

readonly class UserCheckNotExistsService implements StageContract
{
    /**
     * @throws UserValidateException
     */
    public function __invoke($traveler): UserDataService
    {
        return $this->handle($traveler);
    }

    /**
     * @throws UserValidateException
     */
    public function handle(UserDataService $dataService): UserDataService
    {
        if (null === $dataService->getUser()) {
            $constraintViolation = new ConstraintViolation(
                sprintf('User id %s not exists', $dataService->getRetrieveUserQuery()->getUserId()),
                null,
                [],
                null,
                'id',
                ''
            );

            $constraintViolationList = new ConstraintViolationList([$constraintViolation]);

            throw new UserValidateException($constraintViolationList, Response::HTTP_NOT_FOUND);
        }

        return $dataService;
    }
}
