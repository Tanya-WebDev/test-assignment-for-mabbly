<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomLeave;

use App\Domain\ChatRoom\Services\ChatRoomCheckNotExistsService;
use App\Domain\ChatRoom\Services\ChatRoomDataService;
use App\Domain\ChatRoom\Services\ChatRoomLeaveService;
use App\Domain\ChatRoom\Services\ChatRoomRetrieveService;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve\ChatRoomRetrieveQuery;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomLeaveCommandHandler
{
    public function __construct(
        private ChatRoomRetrieveService $chatRoomRetrieveService,
        private ChatRoomCheckNotExistsService $chatRoomCheckNotExistsService,
        private ChatRoomLeaveService $chatRoomLeaveService,
    ) {
    }

    public function __invoke(ChatRoomLeaveCommand $chatRoomLeaveCommand): ChatRoomDataService
    {
        $chatRoomDataService = (new ChatRoomDataService())
            ->setChatRoomLeaveCommand($chatRoomLeaveCommand)
            ->setChatRoomRetrieveQuery(new ChatRoomRetrieveQuery($chatRoomLeaveCommand->getChatRoomId()))
        ;

        (new Pipeline())
            ->pipe($this->chatRoomRetrieveService)
            ->pipe($this->chatRoomCheckNotExistsService)
            ->pipe($this->chatRoomLeaveService)
            ->process($chatRoomDataService)
        ;

        return $chatRoomDataService;
    }
}
