<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Request;

use App\Domain\ChatRoom\UseCase\Command\ChatRoomDelete\ChatRoomDeleteCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ChatRoomDeleteRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ChatRoomDeleteCommand::class === $argument->getType()) {
            return [ChatRoomDeleteCommand::fromRequest($request)];
        }

        return [];
    }
}
