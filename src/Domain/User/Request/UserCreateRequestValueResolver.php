<?php

declare(strict_types=1);

namespace App\Domain\User\Request;

use App\Domain\User\UseCase\Command\UserCreate\UserCreateCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class UserCreateRequestValueResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (UserCreateCommand::class === $argument->getType()) {
            return [UserCreateCommand::fromRequest($request)];
        }

        return [];
    }
}
