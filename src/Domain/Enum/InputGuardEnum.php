<?php

declare(strict_types = 1);

namespace App\Domain\Enum;

enum InputGuardEnum
{
    case SUCCESS;
    case FAILED_VALIDATION;
    case FAILED_SANITISATION;
    case FAILED_ERROR;
}