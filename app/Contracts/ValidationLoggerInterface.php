<?php

namespace App\Contracts;

interface ValidationLoggerInterface
{
    public function log(string $level, string $message, array $context = []): void;
    public function logError(\Throwable $exception, array $context = []): void;
}
