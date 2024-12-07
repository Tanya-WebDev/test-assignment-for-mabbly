<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Command\UserUpdate;

use App\Application\Bus\BaseCommand;
use App\Application\ValueObjects\UiidValueObject;
use SensitiveParameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserUpdateCommand extends BaseCommand
{
    private UiidValueObject $userId;
    private string $password;
    #[Assert\Length(min: 1, max: 20)]
    private string $firstName;
    private string $lastName;

    public function __construct(
        string $userId,
        #[SensitiveParameter]
        string $password,
        string $firstName,
        string $lastName,
    ) {
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->userId = new UiidValueObject($userId);
    }

    public static function fromRequest(Request $request): self
    {
        $payload = $request->getPayload();

        return new self(
            userId: $request->get('id'),
            password: $payload->get('password'),
            firstName: $payload->get('first_name'),
            lastName: $payload->get('last_name'),
        );
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getUserId(): string
    {
        return (string) $this->userId;
    }
}
