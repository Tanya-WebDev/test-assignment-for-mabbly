<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use App\Domain\User\UseCase\Command\UserUpdate\UserUpdateCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class UserUpdateRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (UserUpdateCommand::class === $argument->getType()) {
            return [UserUpdateCommand::fromRequest($request)];
        }

        return [];
    }
}
