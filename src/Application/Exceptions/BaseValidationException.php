<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class BaseValidationException extends Exception implements ValidateExceptionInterface
{
    private ConstraintViolationListInterface $violations;

    public function __construct(ConstraintViolationListInterface $violationList, $code = 400, ?Throwable $previous = null)
    {
        $this->violations = $violationList;

        parent::__construct('Request data is not valid', $code, $previous);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
