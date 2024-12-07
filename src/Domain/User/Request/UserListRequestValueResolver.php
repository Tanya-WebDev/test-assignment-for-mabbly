<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use App\Domain\User\UseCase\Query\UsersList\UserListQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class UserListRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (UserListQuery::class === $argument->getType()) {
            return [UserListQuery::fromRequest($request)];
        }

        return [];
    }
}
