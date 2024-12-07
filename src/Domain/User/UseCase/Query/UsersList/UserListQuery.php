<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Query\UsersList;

use App\Application\Bus\BaseQuery;
use Symfony\Component\HttpFoundation\Request;

class UserListQuery extends BaseQuery
{
    private int $page;

    public function __construct(int $page)
    {
        $this->page = $page;
    }

    public static function fromRequest(Request $request): UserListQuery
    {
        return new self(
            (int) $request->get('page', 1),
        );
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
