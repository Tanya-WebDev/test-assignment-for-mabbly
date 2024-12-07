<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $message = [];
        $message['command'] = 'SYSTEM_FAILURE';
        $message['message'] = $exception->getMessage();

        if ($exception->getPrevious() instanceof BaseValidationException) {
            $message['error'] = $this->prepareValidationMessage($exception->getPrevious());
            $message['command'] = 'VALIDATION_ERROR';

            if ('dev' === $_ENV['APP_ENV']) {
                $message['trace'] = $exception->getPrevious()->getTrace();
            }

            $response = new JsonResponse($message);
            $response->setStatusCode($exception->getPrevious()->getCode());
            $response->headers->set('Content-Type', 'application/json');
            $event->setResponse($response);

            return;
        }

        $response = new JsonResponse($message);
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->set('Content-Type', 'application/json');
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }

    private function prepareValidationMessage(?ValidateExceptionInterface $validationException): array
    {
        if (null === $validationException) {
            return [
                'system' => 'process request failed',
            ];
        }

        $errors = [];
        foreach ($validationException->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}
