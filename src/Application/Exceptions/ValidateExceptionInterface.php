<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

interface ValidateExceptionInterface extends Throwable
{
    public function getViolations(): ConstraintViolationListInterface;
}
