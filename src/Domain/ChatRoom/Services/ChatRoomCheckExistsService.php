<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Exceptions\ChatRoomValidateException;
use App\Domain\ChatRoom\Repository\ChatRoomRepository;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

readonly class ChatRoomCheckExistsService implements StageContract
{
    public function __construct(
        private ChatRoomRepository $chatRoomRepository,
    ) {
    }

    /**
     * @throws ChatRoomValidateException
     */
    public function __invoke($traveler): ChatRoomDataService
    {
        return $this->handle($traveler);
    }

    /**
     * @throws ChatRoomValidateException
     */
    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        $isChatRoomExists = $this->chatRoomRepository->chatRoomExistsByLogin($dataService->getChatRoomCreateCommand()->getTitle());

        if (true === $isChatRoomExists) {
            $constraintViolation = new ConstraintViolation(
                sprintf('Chat room %s already exists', $dataService->getChatRoomCreateCommand()->getTitle()),
                null,
                [],
                null,
                'login',
                ''
            );

            $constraintViolationList = new ConstraintViolationList([$constraintViolation]);

            throw new ChatRoomValidateException($constraintViolationList);
        }

        return $dataService;
    }
}
