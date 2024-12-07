<?php

declare(strict_types=1);

namespace App\Application\ValueObjects;

use InvalidArgumentException;
use Symfony\Component\Uid\UuidV6;

class UiidValueObject
{
    private string $uuidId;

    public function __construct(string $uuidId)
    {
        if (!UuidV6::isValid($uuidId)) {
            throw new InvalidArgumentException('User ID is not a valid UUID.');
        }

        $this->uuidId = $uuidId;
    }

    public function __toString(): string
    {
        return $this->uuidId;
    }
}
