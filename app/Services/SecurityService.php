<?php

namespace App\Services;

class SecurityService
{
    public function sanitize(string $input): string
    {
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}
