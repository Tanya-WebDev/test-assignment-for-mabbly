<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Entity\ChatRoom;
use App\Domain\ChatRoom\Repository\ChatRoomRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomRetrieveService implements StageContract
{
    public function __construct(
        private ChatRoomRepository $chatRoomRepository,
    ) {
    }

    public function handle(string $id): ?ChatRoom
    {
        return $this->chatRoomRepository->find($id);
    }

    /**
     * @param ChatRoomDataService $traveler
     */
    public function __invoke($traveler): ChatRoomDataService
    {
        $chatRoom = $this->handle($traveler->getChatRoomRetrieveQuery()?->getChatRoomId());

        $traveler->setChatRoom($chatRoom);

        return $traveler;
    }
}
