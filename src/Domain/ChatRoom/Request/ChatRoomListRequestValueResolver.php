<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Request;

use App\Domain\ChatRoom\UseCase\Query\ChatRoomList\ChatRoomListQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ChatRoomListRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ChatRoomListQuery::class === $argument->getType()) {
            return [ChatRoomListQuery::fromRequest($request)];
        }

        return [];
    }
}
