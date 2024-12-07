<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Repository;

use App\Domain\ChatRoom\Entity\ChatRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ChatRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatRoom::class);
    }

    public function chatRoomExistsByLogin(string $title): bool
    {
        return 1 === $this->count(['title' => $title]);
    }

    public function save(ChatRoom $chatRoom): void
    {
        $this->getEntityManager()->persist($chatRoom);
        $this->getEntityManager()->flush();
    }

    public function delete(ChatRoom $chatRoom): void
    {
        $this->getEntityManager()->remove($chatRoom);
        $this->getEntityManager()->flush();
    }

    public function getQueryBuilderChatRoomsByOwner(string $id): QueryBuilder
    {
        return $this->createQueryBuilder('cm')
            ->where('cm.owner = :owner')
            ->setParameter('owner', $id);
    }
}
