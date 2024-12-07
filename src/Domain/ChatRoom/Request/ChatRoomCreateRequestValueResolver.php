<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Request;

use App\Domain\ChatRoom\UseCase\Command\ChatRoomCreate\ChatRoomCreateCommand;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class ChatRoomCreateRequestValueResolver implements ValueResolverInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (ChatRoomCreateCommand::class === $argument->getType()) {
            return [ChatRoomCreateCommand::fromRequest($request, $this->security->getUser())];
        }

        return [];
    }
}
