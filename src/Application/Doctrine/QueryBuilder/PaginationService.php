<?php

declare(strict_types=1);

namespace App\Application\Doctrine\QueryBuilder;

use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;

class PaginationService
{
    public static function paginate(QueryBuilder $queryBuilder, int $page = 1, int $limit = 10): array
    {
        if ($page < 1) {
            throw new InvalidArgumentException('Page number must be greater than 0.');
        }

        if ($limit <= 0) {
            throw new InvalidArgumentException('Limit must be greater than 0.');
        }

        $offset = ($page - 1) * $limit;

        $countQueryBuilder = clone $queryBuilder;
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $totalItems = (int) $countQueryBuilder->select(sprintf('COUNT(DISTINCT %s.id)', $rootAlias))
            ->resetDQLPart('orderBy')
            ->getQuery()
            ->getSingleScalarResult();

        $items = $queryBuilder
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        $totalPages = (int) ceil($totalItems / $limit);

        return [
            'items' => $items,
            'totalItems' => $totalItems,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
        ];
    }
}
