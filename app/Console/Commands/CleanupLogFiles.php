<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanupLogFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-log-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old log files based on retention policies in config/logging.php';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting log file cleanup...');

        $channels = config('logging.channels');

        foreach ($channels as $name => $config) {
            if ($config['driver'] === 'daily' && isset($config['days'])) {
                $this->cleanupChannel($name, $config);
            }
        }

        $this->info('Log file cleanup complete.');
    }

    protected function cleanupChannel(string $name, array $config)
    {
        $path = $config['path'];
        $days = $config['days'];
        $files = glob(dirname($path) . '/' . basename($path, '.log') . '-*.log');

        foreach ($files as $file) {
            if (strtotime('now') - filemtime($file) > $days * 86400) {
                unlink($file);
                $this->line("Deleted old log file: {$file}");
            }
        }
    }
}
