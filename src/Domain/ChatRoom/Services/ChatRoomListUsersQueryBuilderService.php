<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Repository\ChatRoomMembershipRepository;
use Doctrine\ORM\QueryBuilder;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomListUsersQueryBuilderService implements StageContract
{
    public function __construct(
        private ChatRoomMembershipRepository $chatRoomMembershipRepository,
    ) {
    }

    public function handle(string $chatRoomId): QueryBuilder
    {
        return $this
            ->chatRoomMembershipRepository
            ->getQueryBuilderChatUsersMemberShipByChatId($chatRoomId);
    }

    /**
     * @param ChatRoomDataService $traveler
     */
    public function __invoke($traveler): QueryBuilder
    {
        return $this->handle('');
    }
}
