<?php

declare(strict_types=1);

namespace App\Domain\Report\UseCase\Query\ReportRetrieveCsv;

use App\Domain\Report\Services\ReportChatRoomsCsvService;
use Doctrine\DBAL\Exception;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class ReportRetrieveCsvQueryHandler
{
    public function __construct(
        private ReportChatRoomsCsvService $chatRoomsCsvService,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ReportRetrieveCsvQuery $retrieveCsvQuery): array
    {
        return $this->chatRoomsCsvService->handle();
    }
}
