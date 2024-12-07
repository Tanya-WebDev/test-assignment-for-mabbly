<?php

namespace App\UI\Http\Rest;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    #[Route('/lucky/number/{max}', name: 'app_lucky_number')]
    public function number(int $max): Response
    {
        $user = new User();
        $user->setLogin('tester21');
        $user->setFirstName('tester');
        $user->setLastName('tester21');

        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'tester'));

        $this->repository->getEntityManager()->persist($user);
        $this->repository->getEntityManager()->flush();

        $number = random_int(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
