<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Exceptions\ChatRoomValidateException;
use App\Domain\ChatRoom\Repository\ChatRoomMembershipRepository;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

readonly class ChatRoomCheckAlreadyJoinedService implements StageContract
{
    public function __construct(
        private ChatRoomMembershipRepository $chatRoomMembershipRepository,
    ) {
    }

    /**
     * @throws ChatRoomValidateException
     */
    public function __invoke($traveler): ChatRoomDataService
    {
        return $this->handle($traveler);
    }

    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        $alreadyJoined = $this->chatRoomMembershipRepository->findOneBy([
            'chatRoom' => $dataService->getChatRoom(),
            'user' => $dataService->getChatRoomJoinCommand()?->getUser(),
        ]);

        if (null !== $alreadyJoined) {
            $constraintViolation = new ConstraintViolation(
                sprintf('You already joined to chat "%s"', $dataService->getChatRoom()?->getTitle()),
                null,
                [],
                null,
                'id',
                ''
            );

            $constraintViolationList = new ConstraintViolationList([$constraintViolation]);

            throw new ChatRoomValidateException($constraintViolationList, Response::HTTP_BAD_REQUEST);
        }

        return $dataService;
    }
}
