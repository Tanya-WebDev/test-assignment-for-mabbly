<?php

declare(strict_types=1);

namespace App\Application\Bus;

class BaseQuery
{
    private string $queryStatus = 'success';

    public function getObjectState(): string
    {
        return $this->queryStatus;
    }

    public function setQueryStatus(string $queryStatus): void
    {
        $this->queryStatus = $queryStatus;
    }

    public function is(): string
    {
        return 'query';
    }
}
