<?php

declare(strict_types=1);

namespace App\Domain\Report\Services;

use App\Domain\Report\Repository\ReportRepository;
use Doctrine\DBAL\Exception;

readonly class ReportChatRoomsCsvService
{
    public function __construct(
        private ReportRepository $reportRepository,
    ) {
    }

    /**
     * @throws Exception
     */
    public function handle(): array
    {
        return $this->reportRepository->generateChatRoomReport();
    }
}
