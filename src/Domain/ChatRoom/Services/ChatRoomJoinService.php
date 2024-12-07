<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Entity\ChatRoomMembership;
use App\Domain\ChatRoom\Repository\ChatRoomMembershipRepository;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomJoinService implements StageContract
{
    public function __construct(
        private ChatRoomMembershipRepository $chatRoomMembershipRepository,
    ) {
    }

    public function handle(ChatRoomDataService $dataService): ChatRoomDataService
    {
        $chatRoomMemberShip = new ChatRoomMembership();
        $chatRoomMemberShip->setUser($dataService->getChatRoomJoinCommand()?->getUser());
        $chatRoomMemberShip->setChatRoom($dataService->getChatRoom());

        $this->chatRoomMembershipRepository->save($chatRoomMemberShip);

        $dataService->setChatRoomMemberShipJoinId($chatRoomMemberShip->getId());

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
