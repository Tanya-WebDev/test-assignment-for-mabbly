<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomUpdate;

use App\Application\Bus\BaseCommand;
use App\Application\ValueObjects\UiidValueObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ChatRoomUpdateCommand extends BaseCommand
{
    private UiidValueObject $chatRoomId;
    #[Assert\Length(min: 1, max: 255)]
    private string $title;
    private string $description;
    private bool $public;

    public function __construct(
        string $chatRoomId,
        string $title,
        string $description,
        bool $public,
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->public = $public;
        $this->chatRoomId = new UiidValueObject($chatRoomId);
    }

    public static function fromRequest(Request $request): self
    {
        $payload = $request->getPayload();

        return new self(
            chatRoomId: $request->get('id'),
            title: $payload->get('title'),
            description: $payload->get('description'),
            public: $payload->get('public', false),
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function isPublic(): bool
    {
        return $this->public;
    }

    public function getChatRoomId(): string
    {
        return (string) $this->chatRoomId;
    }
}
