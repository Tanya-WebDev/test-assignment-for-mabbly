<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use App\Domain\User\UseCase\Command\UserDelete\UserDeleteCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class UserDeleteRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (UserDeleteCommand::class === $argument->getType()) {
            return [UserDeleteCommand::fromRequest($request)];
        }

        return [];
    }
}
