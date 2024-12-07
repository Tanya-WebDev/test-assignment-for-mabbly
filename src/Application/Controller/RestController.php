<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class RestController extends AbstractController
{
    public function __construct(
        protected readonly MessageBusInterface $bus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function handle($command)
    {
        $envelope = $this->bus->dispatch($command);

        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
