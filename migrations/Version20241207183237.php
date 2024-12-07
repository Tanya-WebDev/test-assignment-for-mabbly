<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241207183237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('CREATE TABLE chat_room_memberships (id UUID NOT NULL, user_id UUID NOT NULL, chat_room_id UUID NOT NULL, joined_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX chat_room_memberships_chat_room_id_user_id_index ON chat_room_memberships (chat_room_id, user_id)');
        $this->addSql('CREATE INDEX idx_67033d841819bcfa ON chat_room_memberships (chat_room_id)');
        $this->addSql('CREATE INDEX idx_67033d84a76ed395 ON chat_room_memberships (user_id)');
        $this->addSql('COMMENT ON COLUMN chat_room_memberships.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN chat_room_memberships.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN chat_room_memberships.chat_room_id IS \'(DC2Type:uuid)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('CREATE TABLE users (id UUID NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_1483a5e9aa08cb10 ON users (login)');
        $this->addSql('COMMENT ON COLUMN users.id IS \'(DC2Type:uuid)\'');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('CREATE TABLE chat_rooms (id UUID NOT NULL, owner_id UUID NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, public BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7ddcf70d7e3c61f9 ON chat_rooms (owner_id)');
        $this->addSql('COMMENT ON COLUMN chat_rooms.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN chat_rooms.owner_id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('DROP TABLE chat_room_memberships');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('DROP TABLE users');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('DROP TABLE chat_rooms');
    }
}
