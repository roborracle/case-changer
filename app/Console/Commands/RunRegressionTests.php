<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\QA\QAService;

class RunRegressionTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qa:run-regression';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run regression tests and store the results.';

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
        $this->info('Running regression tests...');

        $result = $this->qaService->runRegressionTests();

        $this->line($result['test_output']);

        $this->info('Regression test run completed and results stored.');

        return 0;
    }
}
