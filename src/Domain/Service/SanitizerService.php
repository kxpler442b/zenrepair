<?php
declare(strict_types=1);

namespace App\Domain\Service;

final class SanitizerService
{

    public function sanitizeEmail(string $emailToBeSanitised) : string
    {
        return filter_var($emailToBeSanitised, FILTER_SANITIZE_EMAIL);
    }

    public function sanitizeString(string $stringToBeSanitized) : string
    {
        return preg_replace("/[^A-zÀ-ú0-9]+/", "", $stringToBeSanitized);
    }

}