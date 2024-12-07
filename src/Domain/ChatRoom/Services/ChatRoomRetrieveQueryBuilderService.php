<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Repository\ChatRoomRepository;
use Doctrine\ORM\QueryBuilder;
use Rockett\Pipeline\Contracts\StageContract;

readonly class ChatRoomRetrieveQueryBuilderService implements StageContract
{
    public function __construct(
        private ChatRoomRepository $chatRoomRepository,
    ) {
    }

    public function handle(): QueryBuilder
    {
        return $this->chatRoomRepository->createQueryBuilder('cr');
    }

    public function __invoke($traveler): QueryBuilder
    {
        return $this->handle();
    }
}
