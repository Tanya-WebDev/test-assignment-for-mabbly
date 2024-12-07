<?php

namespace App\Tests\Domain\User\Services;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use App\Domain\User\Services\UserCreateService;
use App\Domain\User\Services\UserDataService;
use App\Domain\User\UseCase\Command\UserCreate\UserCreateCommand;
use PHPUnit\Framework\MockObject\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateServiceTest extends KernelTestCase
{
    /**
     * @throws Exception
     */
    public function testCreateUser(): void
    {
        self::bootKernel();

        $container = static::getContainer();


        $user = new User();
        $user->setLogin('tester20');

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository
            ->expects($this->once())
            ->method('save')
        ;

        $userPasswordHasher = $container->get(UserPasswordHasherInterface::class);

        $userCreateService = new UserCreateService(
            $userRepository,
            $userPasswordHasher
        );

        $userDataService = (new UserDataService())
            ->setCreateUserCommand(
                (new UserCreateCommand(
                    'tester20',
                    'tester20',
                    'tester20',
                    'tester20',
                ))
            )
        ;

        $userCreateService->handle($userDataService);

        $this->assertEquals(
            $user->getLogin(),
            $userDataService->getUser()->getLogin()
        );
    }
}