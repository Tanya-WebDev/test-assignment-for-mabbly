<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomDelete;

use App\Domain\ChatRoom\Services\ChatRoomCheckNotExistsService;
use App\Domain\ChatRoom\Services\ChatRoomDataService;
use App\Domain\ChatRoom\Services\ChatRoomDeleteService;
use App\Domain\ChatRoom\Services\ChatRoomRetrieveService;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve\ChatRoomRetrieveQuery;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomDeleteCommandHandler
{
    public function __construct(
        private ChatRoomRetrieveService $chatRoomRetrieveService,
        private ChatRoomCheckNotExistsService $chatRoomCheckNotExistsService,
        private ChatRoomDeleteService $chatRoomDeleteService,
    ) {
    }

    public function __invoke(ChatRoomDeleteCommand $chatRoomDeleteCommand): void
    {
        $userDataService = (new ChatRoomDataService())
            ->setChatRoomDeleteCommand($chatRoomDeleteCommand)
            ->setChatRoomRetrieveQuery(new ChatRoomRetrieveQuery($chatRoomDeleteCommand->getChatRoomId()))
        ;

        (new Pipeline())
            ->pipe($this->chatRoomRetrieveService)
            ->pipe($this->chatRoomCheckNotExistsService)
            ->pipe($this->chatRoomDeleteService)
            ->process($userDataService)
        ;
    }
}
