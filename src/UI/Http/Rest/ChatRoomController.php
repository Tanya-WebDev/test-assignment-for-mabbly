<?php

declare(strict_types=1);

namespace App\UI\Http\Rest;

use App\Application\Controller\RestController;
use App\Domain\ChatRoom\Services\ChatRoomDataService;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomCreate\ChatRoomCreateCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomDelete\ChatRoomDeleteCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomJoin\ChatRoomJoinCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomLeave\ChatRoomLeaveCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomUpdate\ChatRoomUpdateCommand;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomList\ChatRoomListQuery;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomListUsers\ChatRoomListUsersQuery;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve\ChatRoomRetrieveQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class ChatRoomController extends RestController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat', methods: ['POST'])]
    public function create(ChatRoomCreateCommand $chatRoomCreateCommand): JsonResponse
    {
        /** @var ChatRoomDataService $chatRoomDataService */
        $chatRoomDataService = $this->handle($chatRoomCreateCommand);

        return $this->json(
            ['command' => $chatRoomCreateCommand->getObjectState()]
            + $chatRoomDataService->getChatRoom()?->jsonSerialize()
        );
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat', methods: ['GET'])]
    public function list(ChatRoomListQuery $chatRoomListQuery): JsonResponse
    {
        $paginationResults = $this->handle($chatRoomListQuery);

        return $this->json(
            ['query' => $chatRoomListQuery->getObjectState()] + $paginationResults
        );
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat/{id}', requirements: ['id' => Requirement::UUID_V6], methods: ['GET'])]
    public function retrieve(ChatRoomRetrieveQuery $chatRoomRetrieveQuery): JsonResponse
    {
        $response = $this->handle($chatRoomRetrieveQuery);

        return $this->json(
            ['query' => $chatRoomRetrieveQuery->getObjectState()]
            + $response->jsonSerialize()
        );
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat/{id}', requirements: ['id' => Requirement::UUID_V6], methods: ['PUT'])]
    public function update(ChatRoomUpdateCommand $chatRoomUpdateCommand): JsonResponse
    {
        $chatRoomDataService = $this->handle($chatRoomUpdateCommand);

        return $this->json(
            ['command' => $chatRoomUpdateCommand->getObjectState()]
            + $chatRoomDataService->getChatRoom()->jsonSerialize()
        );
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat/{id}', requirements: ['id' => Requirement::UUID_V6], methods: ['DELETE'])]
    public function delete(ChatRoomDeleteCommand $chatRoomDeleteCommand): JsonResponse
    {
        $this->handle($chatRoomDeleteCommand);

        return $this->json(
            ['command' => $chatRoomDeleteCommand->getObjectState()]
        );
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat/{id}/join', requirements: ['id' => Requirement::UUID_V6], methods: ['POST'])]
    public function join(ChatRoomJoinCommand $chatRoomJoinCommand): JsonResponse
    {
        /** @var ChatRoomDataService $chatRoomDataService */
        $chatRoomDataService = $this->handle($chatRoomJoinCommand);

        return $this->json([
            'command' => $chatRoomJoinCommand->getObjectState(),
            'join_id' => $chatRoomDataService->getChatRoomMemberShipJoinId(),
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat/{id}/leave', requirements: ['id' => Requirement::UUID_V6], methods: ['DELETE'])]
    public function leave(ChatRoomLeaveCommand $chatRoomLeaveCommand): JsonResponse
    {
        $this->handle($chatRoomLeaveCommand);

        return $this->json([
            'command' => $chatRoomLeaveCommand->getObjectState(),
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/chat/{id}/users', requirements: ['id' => Requirement::UUID_V6], methods: ['GET'])]
    public function listChatUsers(ChatRoomListUsersQuery $chatRoomListUsersQuery): JsonResponse
    {
        $paginationResults = $this->handle($chatRoomListUsersQuery);

        return $this->json(
            ['query' => $chatRoomListUsersQuery->getObjectState()]
            + $paginationResults
        );
    }
}
