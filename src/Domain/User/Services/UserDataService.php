<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\User\Entity\User;
use App\Domain\User\UseCase\Command\UserCreate\UserCreateCommand;
use App\Domain\User\UseCase\Command\UserDelete\UserDeleteCommand;
use App\Domain\User\UseCase\Command\UserUpdate\UserUpdateCommand;
use App\Domain\User\UseCase\Query\UserRetrieve\UserRetrieveQuery;

class UserDataService
{
    private ?UserCreateCommand $createUserCommand = null;

    private ?UserUpdateCommand $userUpdateCommand = null;

    private ?UserRetrieveQuery $retrieveUserQuery = null;

    private ?UserDeleteCommand $userDeleteCommand = null;

    private ?User $user;

    public function getCreateUserCommand(): ?UserCreateCommand
    {
        return $this->createUserCommand;
    }

    public function setCreateUserCommand(UserCreateCommand $createUserCommand): self
    {
        $this->createUserCommand = $createUserCommand;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRetrieveUserQuery(): UserRetrieveQuery
    {
        return $this->retrieveUserQuery;
    }

    public function setRetrieveUserQuery(UserRetrieveQuery $retrieveUserQuery): self
    {
        $this->retrieveUserQuery = $retrieveUserQuery;

        return $this;
    }

    public function getUserUpdateCommand(): ?UserUpdateCommand
    {
        return $this->userUpdateCommand;
    }

    public function setUserUpdateCommand(UserUpdateCommand $userUpdateCommand): self
    {
        $this->userUpdateCommand = $userUpdateCommand;

        return $this;
    }

    public function getUserDeleteCommand(): ?UserDeleteCommand
    {
        return $this->userDeleteCommand;
    }

    public function setUserDeleteCommand(?UserDeleteCommand $userDeleteCommand): self
    {
        $this->userDeleteCommand = $userDeleteCommand;

        return $this;
    }
}
