<?php

declare(strict_types=1);

namespace App\Domain\Report\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class ReportRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function generateChatRoomReport(): array
    {
        $sql = "
            SELECT 
                cr.id AS chat_room_id,
                cr.title AS chat_room_name,
                cr.public AS is_public,
                CONCAT(u.first_name, ' ', u.last_name) AS owner_name,
                (
                    SELECT COUNT(*) 
                    FROM chat_room_memberships crm 
                    WHERE crm.chat_room_id = cr.id AND crm.joined_at > NOW() - INTERVAL '1 hour'
                ) AS joined_last_1h,
                (
                    SELECT COUNT(*) 
                    FROM chat_room_memberships crm 
                    WHERE crm.chat_room_id = cr.id AND crm.joined_at > NOW() - INTERVAL '24 hours'
                ) AS joined_last_24h,
                (
                    SELECT COUNT(*) 
                    FROM chat_room_memberships crm 
                    WHERE crm.chat_room_id = cr.id AND crm.joined_at > NOW() - INTERVAL '1 year'
                ) AS joined_last_1y,
                (
                    SELECT COUNT(*) 
                    FROM chat_room_memberships crm 
                    WHERE crm.chat_room_id = cr.id
                ) AS joined_total,
                (
                    SELECT COUNT(*) * 1.0 / (DATE_PART('epoch', NOW() - cr.created_at) / 3600)
                    FROM chat_room_memberships crm 
                    WHERE crm.chat_room_id = cr.id
                ) AS joined_avg_per_hour
            FROM 
                chat_rooms cr
            LEFT JOIN 
                users u ON cr.owner_id = u.id
            ORDER BY 
                joined_avg_per_hour DESC
        ";

        return $this
            ->connection
            ->executeQuery($sql)
            ->fetchAllAssociative();
    }
}
