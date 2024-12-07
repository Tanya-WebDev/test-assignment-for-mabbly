<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\UseCase\Command\ChatRoomCreate;

use App\Application\Bus\BaseCommand;
use App\Domain\User\Entity\User;
use SensitiveParameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ChatRoomCreateCommand extends BaseCommand
{
    #[Assert\Length(min: 1, max: 255)]
    private string $title;
    private string $description;
    private bool $public;
    private User $owner;

    public function __construct(
        string $title,
        string $description,
        bool $public,
        #[SensitiveParameter]
        User|UserInterface $owner,
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->public = $public;
        $this->owner = $owner;
    }

    public static function fromRequest(Request $request, UserInterface $user): self
    {
        $payload = $request->getPayload();

        return new self(
            title: $payload->get('title'),
            description: $payload->get('description'),
            public: $payload->get('public', false),
            owner: $user,
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

    public function getOwner(): User
    {
        return $this->owner;
    }
}
