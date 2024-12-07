<?php

declare(strict_types=1);

namespace App\UI\Cli\User;

use AllowDynamicProperties;
use App\Domain\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AllowDynamicProperties]
#[AsCommand(name: 'app:user:create-admin-user', description: 'Create admin user')]
class CreateAdminUserCommand extends Command
{
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a root user')
            ->setHelp('This command allows you to create a root user with admin privileges.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Root User Creator',
            '=================',
            '',
        ]);

        $userRepository = $this->entityManager->getRepository(User::class);
        $existingRootUser = $userRepository->findOneBy(['login' => 'root']);

        if ($existingRootUser) {
            $output->writeln('<error>Root user already exists!</error>');

            return Command::FAILURE;
        }

        $user = new User();
        $user->setLogin('root');
        $user->setFirstName('root');
        $user->setLastName('root');

        $hashedPassword = $this->passwordHasher->hashPassword($user, 'root_password');
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln('<info>Root user successfully created!</info>');

        return Command::SUCCESS;
    }
}
