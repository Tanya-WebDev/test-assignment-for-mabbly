<?php

declare(strict_types=1);

namespace App\Domain\User\Factory;

use App\Domain\User\Entity\User;
use App\Domain\User\UseCase\Command\UserCreate\UserCreateCommand;

class UserFactory
{
    public static function fromCreateCommand(UserCreateCommand $command): User
    {
        return (new User())
            ->setLogin($command->getLogin())
            ->setFirstName($command->getFirstName())
            ->setLastName($command->getLastName());
    }

    public static function convertUserToArray(User $user): array
    {
        return [
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'roles' => $user->getRoles(),
            'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}
