<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Repository\ChatRoomRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomUpdateService implements StageContract
{
    public function __construct(
        private ChatRoomRepository $chatRoomRepository,
    ) {
    }

    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        $chatRoom = $dataService->getChatRoom();
        $chatRoom->setTitle($dataService->getChatRoomUpdateCommand()?->getTitle());
        $chatRoom->setDescription($dataService->getChatRoomUpdateCommand()?->getDescription());
        $chatRoom->setPublic($dataService->getChatRoomUpdateCommand()?->isPublic());

        $this->chatRoomRepository->save($chatRoom);

        $dataService->setChatRoom($chatRoom);

        return $dataService;
    }

    /**
     * @param ChatRoomDataService $traveler
     */
    public function __invoke($traveler): ChatRoomDataService
    {
        $this->handle($traveler);

        return $traveler;
    }
}
