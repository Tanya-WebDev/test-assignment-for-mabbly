<?php

declare(strict_types=1);

namespace App\UI\Http\Rest;

use App\Application\Controller\RestController;
use App\Domain\User\Entity\User;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Services\UserDataService;
use App\Domain\User\UseCase\Command\UserCreate\UserCreateCommand;
use App\Domain\User\UseCase\Command\UserDelete\UserDeleteCommand;
use App\Domain\User\UseCase\Command\UserUpdate\UserUpdateCommand;
use App\Domain\User\UseCase\Query\UserChatRoomsList\UserChatRoomsListQuery;
use App\Domain\User\UseCase\Query\UserRetrieve\UserRetrieveQuery;
use App\Domain\User\UseCase\Query\UsersList\UserListQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class UserController extends RestController
{
    #[Route('/api/v1/user', methods: ['POST'])]
    public function create(UserCreateCommand $createUserCommand): JsonResponse
    {
        /** @var UserDataService $userDataService */
        $userDataService = $this->handle($createUserCommand);

        return $this->json(
            ['command' => $createUserCommand->getObjectState()] + $userDataService->getUser()?->jsonSerialize()
        );
    }

    #[Route('/api/v1/user', methods: ['GET'])]
    public function list(UserListQuery $userListQuery): JsonResponse
    {
        $paginationResults = $this->handle($userListQuery);

        return $this->json(
            ['query' => $userListQuery->getObjectState()] + $paginationResults
        );
    }

    #[Route('/api/v1/user/{id}', requirements: ['id' => Requirement::UUID_V6], methods: ['GET'])]
    public function retrieve(UserRetrieveQuery $userRetrieveQuery): JsonResponse
    {
        $response = $this->handle($userRetrieveQuery);

        if ($response instanceof User) {
            return $this->json(
                ['query' => $userRetrieveQuery->getObjectState()] + UserFactory::convertUserToArray($response)
            );
        }

        return $response;
    }

    #[Route('/api/v1/user/{id}', requirements: ['id' => Requirement::UUID_V6], methods: ['PUT'])]
    public function update(UserUpdateCommand $userUpdateCommand): JsonResponse
    {
        /** @var UserDataService $userDataService */
        $userDataService = $this->handle($userUpdateCommand);
        $userArray = UserFactory::convertUserToArray($userDataService->getUser());

        return $this->json(
            ['command' => $userUpdateCommand->getObjectState()] + $userArray
        );
    }

    #[Route('/api/v1/user/{id}', requirements: ['id' => Requirement::UUID_V6], methods: ['DELETE'])]
    public function delete(UserDeleteCommand $userDeleteCommand): JsonResponse
    {
        $this->handle($userDeleteCommand);

        return $this->json(
            ['command' => $userDeleteCommand->getObjectState()]
        );
    }

    #[Route('/api/v1/user/{id}/chats', requirements: ['id' => Requirement::UUID_V6], methods: ['GET'])]
    public function listChatRooms(UserChatRoomsListQuery $chatRoomsListQuery): JsonResponse
    {
        $paginationResults = $this->handle($chatRoomsListQuery);

        return $this->json(
            ['query' => $chatRoomsListQuery->getObjectState()] + $paginationResults
        );
    }
}
