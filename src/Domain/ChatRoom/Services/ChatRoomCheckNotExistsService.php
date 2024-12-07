<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Exceptions\ChatRoomValidateException;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

readonly class ChatRoomCheckNotExistsService implements StageContract
{
    /**
     * @throws ChatRoomValidateException
     */
    public function __invoke($traveler): ChatRoomDataService
    {
        return $this->handle($traveler);
    }

    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        if (null === $dataService->getChatRoom()) {
            $constraintViolation = new ConstraintViolation(
                sprintf('Chat room id "%s" not exists', $dataService->getChatRoomRetrieveQuery()->getChatRoomId()),
                null,
                [],
                null,
                'id',
                ''
            );

            $constraintViolationList = new ConstraintViolationList([$constraintViolation]);

            throw new ChatRoomValidateException($constraintViolationList, Response::HTTP_NOT_FOUND);
        }

        return $dataService;
    }
}
