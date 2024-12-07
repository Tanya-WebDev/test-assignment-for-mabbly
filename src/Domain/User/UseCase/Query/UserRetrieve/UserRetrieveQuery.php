<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Query\UserRetrieve;

use App\Application\Bus\BaseQuery;
use App\Application\ValueObjects\UiidValueObject;
use Symfony\Component\HttpFoundation\Request;

class UserRetrieveQuery extends BaseQuery
{
    private UiidValueObject $userId;

    public function __construct(string $userId)
    {
        $this->userId = new UiidValueObject($userId);
    }

    public static function fromRequest(Request $request): UserRetrieveQuery
    {
        return new self(
            (string) $request->get('id', 1),
        );
    }

    public function getUserId(): string
    {
        return (string) $this->userId;
    }
}
