<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class LoggingService implements LoggerInterface
{
    public function emergency($message, array $context = []): void
    {
        Log::channel('emergency')->emergency($message, $context);
    }

    public function alert($message, array $context = []): void
    {
        Log::channel('alert')->alert($message, $context);
    }

    public function critical($message, array $context = []): void
    {
        Log::channel('critical')->critical($message, $context);
    }

    public function error($message, array $context = []): void
    {
        Log::channel('error')->error($message, $context);
    }

    public function warning($message, array $context = []): void
    {
        Log::channel('warning')->warning($message, $context);
    }

    public function notice($message, array $context = []): void
    {
        Log::channel('notice')->notice($message, $context);
    }

    public function info($message, array $context = []): void
    {
        Log::channel('info')->info($message, $context);
    }

    public function debug($message, array $context = []): void
    {
        Log::channel('debug')->debug($message, $context);
    }

    public function log($level, $message, array $context = []): void
    {
        Log::log($level, $message, $context);
    }
}
