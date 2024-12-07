<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Repository\ChatRoomMembershipRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomLeaveService implements StageContract
{
    public function __construct(
        private ChatRoomMembershipRepository $chatRoomMembershipRepository,
    ) {
    }

    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        $this->chatRoomMembershipRepository->leave([
            'userId' => $dataService->getChatRoomLeaveCommand()?->getUser()->getId(),
            'chatRoomId' => $dataService->getChatRoom()?->getId(),
        ]);

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
