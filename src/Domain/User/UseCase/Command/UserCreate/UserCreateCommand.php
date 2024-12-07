<?php

declare(strict_types=1);

namespace App\Domain\User\UseCase\Command\UserCreate;

use App\Application\Bus\BaseCommand;
use SensitiveParameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreateCommand extends BaseCommand
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 16)]
    private string $login;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 255)]
    private string $password;

    #[Assert\Length(min: 1, max: 30)]
    private string $firstName;

    #[Assert\Length(min: 1, max: 30)]
    private string $lastName;

    public function __construct(
        string $login,
        #[SensitiveParameter]
        string $password,
        string $firstName,
        string $lastName,
    ) {
        $this->login = $login;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public static function fromRequest(Request $request): self
    {
        $payload = $request->getPayload();

        return new self(
            login: $payload->get('login'),
            password: $payload->get('password'),
            firstName: $payload->get('first_name'),
            lastName: $payload->get('last_name'),
        );
    }

    public function getLogin(): string
    {
        return $this->login;
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
}
