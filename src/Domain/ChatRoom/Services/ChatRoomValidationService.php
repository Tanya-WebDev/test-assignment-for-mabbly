<?php

declare(strict_types=1);

namespace App\Domain\ChatRoom\Services;

use App\Domain\ChatRoom\Exceptions\ChatRoomValidateException;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomCreate\ChatRoomCreateCommand;
use App\Domain\ChatRoom\UseCase\Command\ChatRoomUpdate\ChatRoomUpdateCommand;
use Rockett\Pipeline\Contracts\StageContract;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ChatRoomValidationService implements StageContract
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @param ChatRoomDataService $traveler
     *
     * @throws ChatRoomValidateException
     */
    public function __invoke($traveler): ChatRoomDataService
    {
        $command = $traveler->getChatRoomCreateCommand() ?? $traveler->getChatRoomUpdateCommand();

        $this->handle($command);

        return $traveler;
    }

    /**
     * @throws ChatRoomValidateException
     */
    public function handle(ChatRoomCreateCommand|ChatRoomUpdateCommand $command): ChatRoomCreateCommand|ChatRoomUpdateCommand
    {
        $errors = $this->validator->validate($command);

        if ($errors->count()) {
            throw new ChatRoomValidateException($errors);
        }

        return $command;
    }
}
