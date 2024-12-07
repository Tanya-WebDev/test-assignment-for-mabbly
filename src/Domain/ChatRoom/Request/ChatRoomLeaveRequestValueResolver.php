<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Request;

use App\Domain\ChatRoom\UseCase\Command\ChatRoomLeave\ChatRoomLeaveCommand;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ChatRoomLeaveRequestValueResolver implements ValueResolverInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ChatRoomLeaveCommand::class === $argument->getType()) {
            return [ChatRoomLeaveCommand::fromRequest($request, $this->security->getUser())];
        }

        return [];
    }
}
