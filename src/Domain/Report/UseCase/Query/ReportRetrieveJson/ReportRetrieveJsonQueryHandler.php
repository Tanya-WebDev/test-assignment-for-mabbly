<?php

declare(strict_types=1);

namespace App\Domain\Report\UseCase\Query\ReportRetrieveJson;

use App\Domain\Report\Services\ReportChatRoomsJsonService;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ReportRetrieveJsonQueryHandler
{
    public function __construct(
        private ReportChatRoomsJsonService $chatRoomsJsonService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ReportRetrieveJsonQuery $retrieveJsonQuery): array
    {
        return $this->chatRoomsJsonService->handle();
    }
}
