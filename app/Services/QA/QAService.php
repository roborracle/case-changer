<?php

namespace App\Services\QA;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Models\QA\TestRun;

class QAService
{
    /**
     * Run regression tests and collect metrics.
     *
     * @return array
     */
    public function runRegressionTests()
    {
        $coverageFile = storage_path('logs/coverage.txt');
        $exitCode = Artisan::call('test', ['--coverage-text' => $coverageFile]);

        $output = Artisan::output();

        $metrics = $this->collectQualityMetrics();

        $this->storeTestHistory($output, $metrics, $exitCode);

        return [
            'test_output' => $output,
            'metrics' => $metrics,
        ];
    }

    /**
     * Store the test execution history.
     *
     * @param string $output
     * @return void
     */
    protected function storeTestHistory(string $output, array $metrics, int $exitCode)
    {
        TestRun::create([
            'test_output' => $output,
            'status' => $exitCode === 0 ? 'passed' : 'failed',
            'metrics' => $metrics,
        ]);
    }

    /**
     * Collect quality metrics.
     *
     * @return array
     */
    protected function collectQualityMetrics()
    {
        $metrics = [
            'mean_time_to_detect' => 'N/A',
            'mean_time_to_repair' => 'N/A',
            'code_coverage' => $this->getCodeCoverage(),
        ];

        return $metrics;
    }

    /**
     * Get code coverage from the latest test run.
     *
     * @return string
     */
    protected function getCodeCoverage()
    {
        $coverageFile = storage_path('logs/coverage.txt');

        if (File::exists($coverageFile)) {
            return File::get($coverageFile);
        }

        return 'N/A';
    }

    /**
     * Generate a QA status report.
     *
     * @return string
     */
    public function generateQAReport()
    {
        $lastRun = TestRun::latest()->first();

        $report = "## QA Status Report - " . now() . "\n\n";

        if ($lastRun) {
            $report .= "### Last Test Run\n";
            $report .= "- **Status:** " . ucfirst($lastRun->status) . "\n";
            $report .= "- **Timestamp:** " . $lastRun->created_at . "\n\n";

            $report .= "### Quality Metrics\n";
            $report .= "- **Mean Time to Detect (MTTD):** " . ($lastRun->metrics['mean_time_to_detect'] ?? 'N/A') . "\n";
            $report .= "- **Mean Time to Repair (MTTR):** " . ($lastRun->metrics['mean_time_to_repair'] ?? 'N/A') . "\n";
            $report .= "- **Code Coverage:** " . ($lastRun->metrics['code_coverage'] ?? 'N/A') . "\n\n";
        } else {
            $report .= "No test runs found.\n\n";
        }

        $report .= "### Release Readiness Assessment\n";
        $report .= "- [ ] All critical tests passing.\n";
        $report .= "- [ ] Code coverage meets threshold.\n";
        $report .= "- [ ] No outstanding critical bugs.\n";

        return $report;
    }
}
