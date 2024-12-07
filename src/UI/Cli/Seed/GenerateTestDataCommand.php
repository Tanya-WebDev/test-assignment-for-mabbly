<?php

declare(strict_types=1);

namespace App\UI\Cli\Seed;

use App\Domain\ChatRoom\Entity\ChatRoom;
use App\Domain\ChatRoom\Entity\ChatRoomMembership;
use App\Domain\User\Entity\User;
use DateMalformedStringException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Random\RandomException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:generate-data', description: 'Populate the database with the specified number of users and chats')]
class GenerateTestDataCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:generate-data')
            ->setDescription('Generates random user and chat data.')
            ->addOption('users', null, InputOption::VALUE_REQUIRED, 'Number of users to create', 1000)
            ->addOption('chats', null, InputOption::VALUE_REQUIRED, 'Number of chat rooms to create', 50)
            ->addOption('chats_per_user_min', null, InputOption::VALUE_REQUIRED, 'Minimum number of chats per user', 3)
            ->addOption('chats_per_user_max', null, InputOption::VALUE_REQUIRED, 'Maximum number of chats per user', 7)
            ->addOption('initial_timestamp', null, InputOption::VALUE_REQUIRED, 'Initial timestamp', '2000-01-31');
    }

    /**
     * @throws DateMalformedStringException
     * @throws RandomException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $faker = Factory::create();
        $usersCount = (int) $input->getOption('users');
        $chatsCount = (int) $input->getOption('chats');
        $chatsPerUserMin = (int) $input->getOption('chats_per_user_min');
        $chatsPerUserMax = (int) $input->getOption('chats_per_user_max');
        $initialTimestamp = new DateTime($input->getOption('initial_timestamp'));

        $users = [];
        $userLoginExists = [];
        for ($i = 0; $i < $usersCount; ++$i) {
            $login = $faker->userName;

            if (in_array($login, $userLoginExists, true)) {
                continue;
            }

            $userLoginExists[] = $login;

            $user = new User();
            $user->setLogin($login)
                ->setPassword($faker->password)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setCreatedAt($this->generateRandomTimestamp($initialTimestamp))
            ;

            $this->entityManager->persist($user);
            $users[] = $user;
        }

        $chatRooms = [];
        for ($i = 0; $i < $chatsCount; ++$i) {
            $chatRoom = new ChatRoom();
            $chatRoom->setOwner($faker->randomElement($users));
            $chatRoom->setTitle($faker->company);
            $chatRoom->setDescription($faker->address);
            $chatRoom->setPublic($faker->boolean);
            $chatRoom->setCreatedAt($this->generateRandomTimestamp($initialTimestamp));

            $this->entityManager->persist($chatRoom);
            $chatRooms[] = $chatRoom;
        }

        foreach ($users as $user) {
            $chatsForUser = random_int($chatsPerUserMin, $chatsPerUserMax);
            $selectedChatRooms = $faker->randomElements($chatRooms, $chatsForUser);

            foreach ($selectedChatRooms as $chatRoom) {
                $membership = new ChatRoomMembership();
                $membership->setUser($user)
                    ->setChatRoom($chatRoom)
                    ->setJoinedAt($this->generateRandomTimestamp($initialTimestamp))
                ;

                $this->entityManager->persist($membership);
            }
        }

        $this->entityManager->flush();

        $output->writeln('<info>Data generated successfully!</info>');

        return Command::SUCCESS;
    }

    /**
     * @throws RandomException
     */
    private function generateRandomTimestamp(DateTime $startDate): DateTime
    {
        $endDate = new DateTime();
        $timestamp = random_int($startDate->getTimestamp(), $endDate->getTimestamp());

        return (new DateTime())->setTimestamp($timestamp);
    }
}
