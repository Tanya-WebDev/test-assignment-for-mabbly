<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Factory\ChatRoomFactory;
use App\Domain\ChatRoom\Repository\ChatRoomRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomCreateService implements StageContract
{
    public function __construct(
        private ChatRoomRepository $chatRoomRepository,
    ) {
    }

    public function __invoke($traveler): ChatRoomDataService
    {
        return $this->handle($traveler);
    }

    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        $chatRoom = ChatRoomFactory::fromCreateCommand($dataService->getChatRoomCreateCommand());
        $this->chatRoomRepository->save($chatRoom);
        $dataService->setChatRoom($chatRoom);

        return $dataService;
    }
}
