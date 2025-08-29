<?php

namespace App\Contracts;

interface ValidationInterface
{
    public function validate(string $input): bool;
    public function getErrors(): array;
    public function logValidationStart(string $input, array $rules): void;
    public function logValidationSuccess(string $input): void;
    public function logValidationFailure(string $input, array $errors): void;
}
