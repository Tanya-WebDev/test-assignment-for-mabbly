<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Exceptions\UserValidateException;
use App\Domain\User\Repository\UserRepository;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

readonly class UserCheckExistsService implements StageContract
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

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
        $isUserLoginExists = $this->userRepository->userExistsByLogin($dataService->getCreateUserCommand()->getLogin());

        if (true === $isUserLoginExists) {
            $constraintViolation = new ConstraintViolation(
                sprintf('User login %s already exists', $dataService->getCreateUserCommand()->getLogin()),
                null,
                [],
                null,
                'login',
                ''
            );

            $constraintViolationList = new ConstraintViolationList([$constraintViolation]);

            throw new UserValidateException($constraintViolationList);
        }

        return $dataService;
    }
}
