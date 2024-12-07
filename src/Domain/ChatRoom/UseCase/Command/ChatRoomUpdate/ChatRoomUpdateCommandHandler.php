<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomUpdate;

use App\Domain\ChatRoom\Services\ChatRoomCheckNotExistsService;
use App\Domain\ChatRoom\Services\ChatRoomDataService;
use App\Domain\ChatRoom\Services\ChatRoomRetrieveService;
use App\Domain\ChatRoom\Services\ChatRoomUpdateService;
use App\Domain\ChatRoom\Services\ChatRoomValidationService;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve\ChatRoomRetrieveQuery;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomUpdateCommandHandler
{
    public function __construct(
        private ChatRoomValidationService $chatRoomValidationService,
        private ChatRoomCheckNotExistsService $chatRoomCheckNotExistsService,
        private ChatRoomRetrieveService $chatRoomRetrieveService,
        private ChatRoomUpdateService $chatRoomUpdateService,
    ) {
    }

    public function __invoke(ChatRoomUpdateCommand $chatRoomUpdateCommand): ChatRoomDataService
    {
        $chatRoomDataService = (new ChatRoomDataService())
            ->setChatRoomUpdateCommand($chatRoomUpdateCommand)
            ->setChatRoomRetrieveQuery(new ChatRoomRetrieveQuery($chatRoomUpdateCommand->getChatRoomId()))
        ;

        (new Pipeline())
            ->pipe($this->chatRoomValidationService)
            ->pipe($this->chatRoomRetrieveService)
            ->pipe($this->chatRoomCheckNotExistsService)
            ->pipe($this->chatRoomUpdateService)
            ->process($chatRoomDataService)
        ;

        return $chatRoomDataService;
    }
}
