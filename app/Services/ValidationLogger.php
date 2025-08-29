<?php

namespace App\Services;

use App\Contracts\ValidationLoggerInterface;
use Illuminate\Support\Facades\Log;

class ValidationLogger implements ValidationLoggerInterface
{
    protected $buffer = [];
    const BUFFER_LIMIT = 100;

    public function __destruct()
    {
        $this->flush();
    }

    public function log(string $level, string $message, array $context = []): void
    {
        $this->buffer[] = compact('level', 'message', 'context');

        if (count($this->buffer) >= self::BUFFER_LIMIT) {
            $this->flush();
        }
    }

    public function logError(\Throwable $exception, array $context = []): void
    {
        $context = array_merge($context, [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'request' => request()->all(),
        ]);

        $this->log('error', 'An exception occurred.', $context);
    }

    public function flush(): void
    {
        if (empty($this->buffer)) {
            return;
        }

        foreach ($this->buffer as $log) {
            Log::channel('validation')->{$log['level']}($log['message'], $log['context']);
        }

        $this->buffer = [];
    }
}
