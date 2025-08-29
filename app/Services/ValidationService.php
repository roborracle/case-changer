<?php

namespace App\Services;

use App\Contracts\ValidationLoggerInterface;

class ValidationService
{
    protected $errors = [];
    protected $toolValidators = [];
    protected $logger;

    public function __construct(ValidationLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function registerToolValidator(string $tool, callable $validator)
    {
        $this->toolValidators[$tool] = $validator;
    }

    public function validateInput(string $input, array $rules, ?string $tool = null): bool
    {
        $this->errors = [];
        $this->logValidationStart($input, $rules, $tool);

        foreach ($rules as $rule => $parameter) {
            $method = 'validate' . ucfirst($rule);
            if (method_exists($this, $method)) {
                if (!$this->$method($input, $parameter)) {
                    return false;
                }
            }
        }

        if ($tool && isset($this->toolValidators[$tool])) {
            if (!$this->toolValidators[$tool]($input, $this)) {
                $this->logValidationFailure($input, $this->getErrors(), $tool);
                return false;
            }
        }

        $this->logValidationSuccess($input, $tool);
        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function validateMaxSize(string $input, int $maxSize): bool
    {
        if (strlen($input) > $maxSize) {
            $this->errors[] = "Input exceeds maximum size of {$maxSize} bytes.";
            return false;
        }
        return true;
    }

    protected function validateEncoding(string $input, string $encoding): bool
    {
        if (!mb_check_encoding($input, $encoding)) {
            $this->errors[] = "Input is not valid {$encoding}.";
            return false;
        }
        return true;
    }

    protected function validateMemory(string $input, int $memoryLimit): bool
    {
        $estimatedMemory = strlen($input) * 2;
        if ($estimatedMemory > $memoryLimit) {
            $this->errors[] = "Processing this input would exceed the memory limit of {$memoryLimit} bytes.";
            return false;
        }
        return true;
    }

    public function logValidationStart(string $input, array $rules, ?string $tool = null): void
    {
        $this->logger->log('info', 'Validation started.', [
            'tool' => $tool,
            'input_hash' => hash('sha256', $input),
            'rules' => $rules,
        ]);
    }

    public function logValidationSuccess(string $input, ?string $tool = null): void
    {
        $this->logger->log('info', 'Validation successful.', [
            'tool' => $tool,
            'input_hash' => hash('sha256', $input),
        ]);
    }

    public function logValidationFailure(string $input, array $errors, ?string $tool = null): void
    {
        $this->logger->log('warning', 'Validation failed.', [
            'tool' => $tool,
            'input_hash' => hash('sha256', $input),
            'errors' => $errors,
        ]);
    }
}
