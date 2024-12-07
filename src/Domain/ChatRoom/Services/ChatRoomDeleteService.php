<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Repository\ChatRoomRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomDeleteService implements StageContract
{
    public function __construct(
        private ChatRoomRepository $chatRoomRepository,
    ) {
    }

    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        $this->chatRoomRepository->delete($dataService->getChatRoom());
        $dataService->setChatRoom(null);

        return $dataService;
    }

    /**
     * @param ChatRoomDataService $traveler
     */
    public function __invoke($traveler): ChatRoomDataService
    {
        return $this->handle($traveler);
    }
}
