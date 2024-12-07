<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use App\Domain\User\UseCase\Query\UserChatRoomsList\UserChatRoomsListQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class UserChatRoomsListRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (UserChatRoomsListQuery::class === $argument->getType()) {
            return [UserChatRoomsListQuery::fromRequest($request)];
        }

        return [];
    }
}
