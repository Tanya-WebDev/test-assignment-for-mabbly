<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Command\UserDelete;

use App\Application\Bus\BaseCommand;
use App\Application\ValueObjects\UiidValueObject;
use Symfony\Component\HttpFoundation\Request;

class UserDeleteCommand extends BaseCommand
{
    private UiidValueObject $userId;

    public function __construct(string $userId)
    {
        $this->userId = new UiidValueObject($userId);
    }

    public static function fromRequest(Request $request): UserDeleteCommand
    {
        return new self((string) $request->get('id', 1));
    }

    public function getUserId(): string
    {
        return (string) $this->userId;
    }
}
