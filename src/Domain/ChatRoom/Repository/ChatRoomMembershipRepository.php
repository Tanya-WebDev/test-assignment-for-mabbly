<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Repository;

use App\Domain\ChatRoom\Entity\ChatRoom;
use App\Domain\ChatRoom\Entity\ChatRoomMembership;
use App\Domain\User\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ChatRoomMembershipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatRoomMembership::class);
    }

    public function save(ChatRoomMembership $chatRoom): void
    {
        $this->getEntityManager()->persist($chatRoom);
        $this->getEntityManager()->flush();
    }

    public function delete(ChatRoomMembership $chatRoom): void
    {
        $this->getEntityManager()->remove($chatRoom);
        $this->getEntityManager()->flush();
    }

    public function leave(array $chatRoomMembershipData): void
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->delete(ChatRoomMembership::class, 'crm')
            ->where('crm.chatRoom = :chatRoomId')
            ->andWhere('crm.user = :userId')
            ->setParameter('chatRoomId', $chatRoomMembershipData['chatRoomId'])
            ->setParameter('userId', $chatRoomMembershipData['userId']);

        $qb->getQuery()->execute();
    }

    public function getQueryBuilderChatUsersMemberShipByChatId(string $chatRoomId): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('u.id as userId', 'u.login', 'u.firstName', 'u.lastName', 'crm.joinedAt')
            ->from(ChatRoomMembership::class, 'crm')
            ->innerJoin(User::class, 'u', 'WITH', 'crm.user = u.id')
            ->where('crm.chatRoom = :chatRoomId')
            ->setParameter('chatRoomId', $chatRoomId);

        return $qb;
    }

    public function getQueryBuilderChatRoomsMemberShipByUserId(string $userId): QueryBuilder
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('cr.id as id', 'cr.title as title', 'cr.description as description', 'cr.public as public', 'cr.createdAt')
            ->from(ChatRoomMembership::class, 'crm')
            ->innerJoin(ChatRoom::class, 'cr', 'WITH', 'cr.id = crm.chatRoom');

        return $qb;
    }
}
