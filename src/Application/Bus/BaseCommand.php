<?php

declare(strict_types=1);

namespace App\Application\Bus;

class BaseCommand
{
    private string $commandStatus = 'success';

    public function getObjectState(): string
    {
        return $this->commandStatus;
    }

    public function setCommandStatus(string $commandStatus): void
    {
        $this->commandStatus = $commandStatus;
    }

    public function is(): string
    {
        return 'command';
    }
}
