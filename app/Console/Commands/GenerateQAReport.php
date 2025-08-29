<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\QA\QAService;

class GenerateQAReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qa:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a QA status report.';

    /**
     * The QAService instance.
     *
     * @var \App\Services\QA\QAService
     */
    protected $qaService;

    /**
     * Create a new command instance.
     *
     * @param  \App\Services\QA\QAService  $qaService
     * @return void
     */
    public function __construct(QAService $qaService)
    {
        parent::__construct();
        $this->qaService = $qaService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generating QA report...');

        $report = $this->qaService->generateQAReport();

        $this->line($report);

        $this->info('QA report generated successfully.');

        return 0;
    }
}
