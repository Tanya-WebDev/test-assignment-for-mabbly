<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Request;

use App\Domain\ChatRoom\UseCase\Command\ChatRoomJoin\ChatRoomJoinCommand;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ChatRoomJoinRequestValueResolver implements ValueResolverInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ChatRoomJoinCommand::class === $argument->getType()) {
            return [ChatRoomJoinCommand::fromRequest($request, $this->security->getUser())];
        }

        return [];
    }
}
