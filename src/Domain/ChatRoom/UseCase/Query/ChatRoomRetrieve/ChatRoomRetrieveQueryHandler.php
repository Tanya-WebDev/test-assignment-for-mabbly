<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve;

use App\Domain\ChatRoom\Entity\ChatRoom;
use App\Domain\ChatRoom\Services\ChatRoomCheckNotExistsService;
use App\Domain\ChatRoom\Services\ChatRoomDataService;
use App\Domain\ChatRoom\Services\ChatRoomRetrieveService;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomRetrieveQueryHandler
{
    public function __construct(
        private ChatRoomRetrieveService $chatRoomRetrieveService,
        private ChatRoomCheckNotExistsService $chatRoomCheckNotExistsService,
    ) {
    }

    public function __invoke(ChatRoomRetrieveQuery $chatRoomRetrieveQuery): ?ChatRoom
    {
        $userDataService = (new ChatRoomDataService())
            ->setChatRoomRetrieveQuery($chatRoomRetrieveQuery);

        (new Pipeline())
            ->pipe($this->chatRoomRetrieveService)
            ->pipe($this->chatRoomCheckNotExistsService)
            ->process($userDataService);

        return $userDataService->getChatRoom();
    }
}
