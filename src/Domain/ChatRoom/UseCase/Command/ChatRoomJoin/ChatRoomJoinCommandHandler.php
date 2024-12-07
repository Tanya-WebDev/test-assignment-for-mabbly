<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomJoin;

use App\Domain\ChatRoom\Services\ChatRoomCheckAlreadyJoinedService;
use App\Domain\ChatRoom\Services\ChatRoomCheckNotExistsService;
use App\Domain\ChatRoom\Services\ChatRoomDataService;
use App\Domain\ChatRoom\Services\ChatRoomJoinService;
use App\Domain\ChatRoom\Services\ChatRoomRetrieveService;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve\ChatRoomRetrieveQuery;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomJoinCommandHandler
{
    public function __construct(
        private ChatRoomRetrieveService $chatRoomRetrieveService,
        private ChatRoomCheckNotExistsService $chatRoomCheckNotExistsService,
        private ChatRoomJoinService $chatRoomJoinService,
        private ChatRoomCheckAlreadyJoinedService $chatRoomCheckAlreadyJoinedService,
    ) {
    }

    public function __invoke(ChatRoomJoinCommand $chatRoomJoinCommand): ChatRoomDataService
    {
        $chatRoomDataService = (new ChatRoomDataService())
            ->setChatRoomJoinCommand($chatRoomJoinCommand)
            ->setChatRoomRetrieveQuery(new ChatRoomRetrieveQuery($chatRoomJoinCommand->getChatRoomId()))
        ;

        (new Pipeline())
            ->pipe($this->chatRoomRetrieveService)
            ->pipe($this->chatRoomCheckNotExistsService)
            ->pipe($this->chatRoomCheckAlreadyJoinedService)
            ->pipe($this->chatRoomJoinService)
            ->process($chatRoomDataService)
        ;

        return $chatRoomDataService;
    }
}
