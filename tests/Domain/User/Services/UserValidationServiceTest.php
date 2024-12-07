<?php

declare(strict_types=1);

namespace App\Tests\Domain\User\Services;

use App\Domain\User\Exceptions\UserValidateException;
use App\Domain\User\Services\UserValidationService;
use App\Domain\User\UseCase\Command\UserCreate\UserCreateCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserValidationServiceTest extends KernelTestCase
{
    public function testCreateCommandValidationError(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $userValidationService = $container->get(UserValidationService::class);

        $userCreateCommand = new UserCreateCommand(
            'tester',
            'test',
            'testFirstNamdsadasdasdasdasdasde',
            'testLastName',
        );
        $this->expectException(UserValidateException::class);
        $this->expectExceptionMessage('Request data is not valid');

        $userValidationService->handle($userCreateCommand);
    }
}