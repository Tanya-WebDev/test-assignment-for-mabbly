<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomCreate;

use App\Domain\ChatRoom\Services\ChatRoomCheckExistsService;
use App\Domain\ChatRoom\Services\ChatRoomCreateService;
use App\Domain\ChatRoom\Services\ChatRoomDataService;
use App\Domain\ChatRoom\Services\ChatRoomValidationService;
use Rockett\Pipeline\Pipeline;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ChatRoomCreateCommandHandler
{
    public function __construct(
        private ChatRoomValidationService $chatRoomValidationService,
        private ChatRoomCheckExistsService $chatRoomCheckExistsService,
        private ChatRoomCreateService $chatRoomCreateService,
    ) {
    }

    public function __invoke(ChatRoomCreateCommand $chatCreateCommand): ChatRoomDataService
    {
        $chatRoomDataService = (new ChatRoomDataService())
            ->setChatRoomCreateCommand($chatCreateCommand)
        ;

        (new Pipeline())
            ->pipe($this->chatRoomValidationService)
            ->pipe($this->chatRoomCheckExistsService)
            ->pipe($this->chatRoomCreateService)
            ->process($chatRoomDataService)
        ;

        return $chatRoomDataService;
    }
}
