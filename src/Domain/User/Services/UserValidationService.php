<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Exceptions\UserValidateException;
use App\Domain\User\UseCase\Command\UserCreate\UserCreateCommand;
use App\Domain\User\UseCase\Command\UserUpdate\UserUpdateCommand;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserValidationService implements StageContract
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @param UserDataService $traveler
     *
     * @throws UserValidateException
     */
    public function __invoke($traveler): UserDataService
    {
        $command = $traveler->getCreateUserCommand() ?? $traveler->getUserUpdateCommand();

        $this->handle($command);

        return $traveler;
    }

    /**
     * @throws UserValidateException
     */
    public function handle(UserCreateCommand|UserUpdateCommand $command): UserCreateCommand|UserUpdateCommand
    {
        $errors = $this->validator->validate($command);

        if ($errors->count()) {
            throw new UserValidateException($errors);
        }

        return $command;
    }
}
