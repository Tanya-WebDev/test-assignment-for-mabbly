<?php

declare(strict_types=1);

namespace App\Domain\User\Services;

use App\Domain\ChatRoom\Repository\ChatRoomMembershipRepository;
use Doctrine\ORM\QueryBuilder;
use Rockett\Pipeline\Contracts\StageContract;

readonly class UserChatRoomsListQueryBuilderService implements StageContract
{
    public function __construct(
        private ChatRoomMembershipRepository $chatRoomMembershipRepository,
    ) {
    }

    public function handle(string $userId): QueryBuilder
    {
        return $this->chatRoomMembershipRepository->getQueryBuilderChatRoomsMemberShipByUserId($userId);
    }

    public function __invoke($traveler): void
    {
    }
}
