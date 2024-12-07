<?php

declare(strict_types=1);

namespace App\Domain\Report\Request;

use App\Domain\Report\UseCase\Query\ReportRetrieveJson\ReportRetrieveJsonQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ReportRetrieveJsonRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ReportRetrieveJsonQuery::class === $argument->getType()) {
            return [new ReportRetrieveJsonQuery()];
        }

        return [];
    }
}
