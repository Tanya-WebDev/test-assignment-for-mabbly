<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Application\ValueObjects\UiidValueObject;
use App\Domain\ChatRoom\Entity\ChatRoom;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomCreate\ChatRoomCreateCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomDelete\ChatRoomDeleteCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomJoin\ChatRoomJoinCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomLeave\ChatRoomLeaveCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomUpdate\ChatRoomUpdateCommand;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomListUsers\ChatRoomListUsersQuery;
use App\Domain\ChatRoom\UseCase\Query\ChatRoomRetrieve\ChatRoomRetrieveQuery;

class ChatRoomDataService
{
    private ?ChatRoomCreateCommand $chatRoomCreateCommand = null;
    private ?ChatRoomRetrieveQuery $chatRoomRetrieveQuery = null;
    private ?ChatRoomUpdateCommand $chatRoomUpdateCommand = null;
    private ?ChatRoomDeleteCommand $chatRoomDeleteCommand = null;
    private ?ChatRoomJoinCommand $chatRoomJoinCommand = null;
    private ?ChatRoomLeaveCommand $chatRoomLeaveCommand = null;
    private ?ChatRoomListUsersQuery $chatRoomListUsersQuery = null;
    private UiidValueObject $chatRoomMemberShipJoinId;
    private ?ChatRoom $chatRoom;

    public function getChatRoomCreateCommand(): ?ChatRoomCreateCommand
    {
        return $this->chatRoomCreateCommand;
    }

    public function setChatRoomCreateCommand(ChatRoomCreateCommand $chatRoomCreateCommand): self
    {
        $this->chatRoomCreateCommand = $chatRoomCreateCommand;

        return $this;
    }

    public function getChatRoom(): ?ChatRoom
    {
        return $this->chatRoom;
    }

    public function setChatRoom(?ChatRoom $chatRoom): void
    {
        $this->chatRoom = $chatRoom;
    }

    public function getChatRoomRetrieveQuery(): ?ChatRoomRetrieveQuery
    {
        return $this->chatRoomRetrieveQuery;
    }

    public function setChatRoomRetrieveQuery(ChatRoomRetrieveQuery $chatRoomRetrieveQuery): self
    {
        $this->chatRoomRetrieveQuery = $chatRoomRetrieveQuery;

        return $this;
    }

    public function setChatRoomUpdateCommand(ChatRoomUpdateCommand $chatRoomUpdateCommand): ChatRoomDataService
    {
        $this->chatRoomUpdateCommand = $chatRoomUpdateCommand;

        return $this;
    }

    public function getChatRoomUpdateCommand(): ?ChatRoomUpdateCommand
    {
        return $this->chatRoomUpdateCommand;
    }

    public function getChatRoomDeleteCommand(): ?ChatRoomDeleteCommand
    {
        return $this->chatRoomDeleteCommand;
    }

    public function setChatRoomDeleteCommand(?ChatRoomDeleteCommand $chatRoomDeleteCommand): ChatRoomDataService
    {
        $this->chatRoomDeleteCommand = $chatRoomDeleteCommand;

        return $this;
    }

    public function getChatRoomJoinCommand(): ?ChatRoomJoinCommand
    {
        return $this->chatRoomJoinCommand;
    }

    public function setChatRoomJoinCommand(?ChatRoomJoinCommand $chatRoomJoinCommand): self
    {
        $this->chatRoomJoinCommand = $chatRoomJoinCommand;

        return $this;
    }

    public function getChatRoomMemberShipJoinId(): string
    {
        return (string) $this->chatRoomMemberShipJoinId;
    }

    public function setChatRoomMemberShipJoinId(string $chatRoomMemberShipJoinId): void
    {
        $this->chatRoomMemberShipJoinId = new UiidValueObject($chatRoomMemberShipJoinId);
    }

    public function getChatRoomLeaveCommand(): ?ChatRoomLeaveCommand
    {
        return $this->chatRoomLeaveCommand;
    }

    public function setChatRoomLeaveCommand(?ChatRoomLeaveCommand $chatRoomLeaveCommand): self
    {
        $this->chatRoomLeaveCommand = $chatRoomLeaveCommand;

        return $this;
    }

    public function getChatRoomListUsersQuery(): ?ChatRoomListUsersQuery
    {
        return $this->chatRoomListUsersQuery;
    }

    public function setChatRoomListUsersQuery(?ChatRoomListUsersQuery $chatRoomListUsersQuery): self
    {
        $this->chatRoomListUsersQuery = $chatRoomListUsersQuery;

        return $this;
    }
}
