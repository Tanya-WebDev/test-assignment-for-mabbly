<?php

declare(strict_types=1);

namespace App\UI\Http\Rest;

use App\Application\Controller\RestController;
use App\Domain\Report\UseCase\Query\ReportRetrieveCsv\ReportRetrieveCsvQuery;
use App\Domain\Report\UseCase\Query\ReportRetrieveJson\ReportRetrieveJsonQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;

class ReportController extends RestController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/report/chats/json', methods: ['GET'])]
    public function reportChatsJson(ReportRetrieveJsonQuery $retrieveJsonQuery): JsonResponse
    {
        $report = $this->handle($retrieveJsonQuery);

        return $this->json([
            'query' => $retrieveJsonQuery->getObjectState(),
            'chats' => $report,
        ]);
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/api/v1/report/chats/csv', methods: ['GET'])]
    public function reportChatsCsv(ReportRetrieveCsvQuery $retrieveCsvQuery): StreamedResponse
    {
        $reportArray = $this->handle($retrieveCsvQuery);

        $response = new StreamedResponse(function () use ($reportArray) {
            $handle = fopen('php://output', 'wb');
            $header = array_keys($reportArray[0]);
            fputcsv($handle, $header);
            foreach ($reportArray as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        });

        $filename = uniqid('report_chats_'.time(), true);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }
}
