<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class LighthouseAlertService
{
    /**
     * Notification channels configuration
     */
    private array $channels = [
        'email' => true,
        'slack' => false,
        'log' => true
    ];
    
    /**
     * Recipients for alerts
     */
    private array $recipients = [
        'email' => ['admin@casechangerpro.com'],
    ];
    
    /**
     * Send alert for score drops
     */
    public function sendScoreAlert(string $url, array $failures): void
    {
        $message = $this->buildAlertMessage($url, $failures);
        
        if ($this->channels['log']) {
            Log::warning('Lighthouse score alert', [
                'url' => $url,
                'failures' => $failures,
                'timestamp' => Carbon::now()->toIso8601String()
            ]);
        }
        
        if ($this->channels['email']) {
            $this->sendEmailAlert($url, $failures, $message);
        }
        
        if ($this->channels['slack'] && $this->recipients['slack']) {
            $this->sendSlackAlert($url, $failures, $message);
        }
    }
    
    /**
     * Send critical performance alert
     */
    public function sendCriticalAlert(string $metric, int $score, string $url): void
    {
        $message = "🚨 CRITICAL ALERT: {$metric} score dropped to {$score} for {$url}";
        
        Log::critical($message);
        
        if ($this->channels['email']) {
            $this->sendEmailAlert($url, [
                $metric => ['score' => $score, 'threshold' => 90, 'difference' => 90 - $score]
            ], $message);
        }
        
        if ($this->channels['slack'] && $this->recipients['slack']) {
            $this->sendSlackNotification([
                'text' => $message,
                'attachments' => [
                    [
                        'color' => 'danger',
                        'title' => 'Immediate Action Required',
                        'text' => "The {$metric} score has dropped critically low",
                        'footer' => 'Lighthouse Monitor',
                        'ts' => time()
                    ]
                ]
            ]);
        }
    }
    
    /**
     * Send success notification when scores improve
     */
    public function sendImprovementNotification(string $url, array $improvements): void
    {
        $message = "✅ Lighthouse scores improved for {$url}";
        
        Log::info('Lighthouse score improvement', [
            'url' => $url,
            'improvements' => $improvements
        ]);
        
        if ($this->channels['slack'] && $this->recipients['slack']) {
            $fields = [];
            foreach ($improvements as $metric => $data) {
                $fields[] = [
                    'title' => ucfirst($metric),
                    'value' => "{$data['old']} → {$data['new']} (+{$data['improvement']})",
                    'short' => true
                ];
            }
            
            $this->sendSlackNotification([
                'text' => $message,
                'attachments' => [
                    [
                        'color' => 'good',
                        'title' => 'Score Improvements',
                        'fields' => $fields,
                        'footer' => 'Lighthouse Monitor',
                        'ts' => time()
                    ]
                ]
            ]);
        }
    }
    
    /**
     * Build alert message
     */
    private function buildAlertMessage(string $url, array $failures): string
    {
        $message = "Lighthouse score alert for {$url}\n\n";
        $message .= "The following metrics are below threshold:\n";
        
        foreach ($failures as $metric => $data) {
            $message .= sprintf(
                "- %s: %d (threshold: %d, difference: -%d)\n",
                ucfirst(str_replace('_', ' ', $metric)),
                $data['score'],
                $data['threshold'],
                $data['difference']
            );
        }
        
        $message .= "\nPlease investigate and take action to improve these scores.";
        
        return $message;
    }
    
    /**
     * Send email alert
     */
    private function sendEmailAlert(string $url, array $failures, string $message): void
    {
        try {
            Log::info('Email alert would be sent', [
                'to' => $this->recipients['email'],
                'subject' => 'Lighthouse Score Alert: ' . $url,
                'message' => $message
            ]);
            
            
        } catch (\Exception $e) {
            Log::error('Failed to send email alert: ' . $e->getMessage());
        }
    }
    
    /**
     * Send Slack alert
     */
    private function sendSlackAlert(string $url, array $failures, string $message): void
    {
        $attachments = [];
        
        foreach ($failures as $metric => $data) {
            $attachments[] = [
                'color' => $this->getColorForScore($data['score']),
                'title' => ucfirst(str_replace('_', ' ', $metric)),
                'text' => sprintf(
                    'Score: %d (Threshold: %d)',
                    $data['score'],
                    $data['threshold']
                ),
                'footer' => sprintf('-%d points below threshold', $data['difference'])
            ];
        }
        
        $payload = [
            'text' => "⚠️ Lighthouse Alert for {$url}",
            'attachments' => $attachments
        ];
        
        $this->sendSlackNotification($payload);
    }
    
    /**
     * Send notification to Slack webhook
     */
    private function sendSlackNotification(array $payload): void
    {
        if (!$this->recipients['slack']) {
            return;
        }
        
        try {
            Http::post($this->recipients['slack'], $payload);
        } catch (\Exception $e) {
            Log::error('Failed to send Slack notification: ' . $e->getMessage());
        }
    }
    
    /**
     * Get color for Slack attachment based on score
     */
    private function getColorForScore(int $score): string
    {
        if ($score >= 90) {
            return 'good';
        } elseif ($score >= 70) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
    
    /**
     * Generate daily report
     */
    public function generateDailyReport(): array
    {
        $report = [
            'date' => Carbon::today()->toDateString(),
            'urls_monitored' => 0,
            'average_scores' => [],
            'failures' => [],
            'improvements' => [],
            'trends' => []
        ];
        
        $todayScores = \DB::table('lighthouse_scores')
            ->whereDate('created_at', Carbon::today())
            ->get();
        
        if ($todayScores->isEmpty()) {
            return $report;
        }
        
        $report['urls_monitored'] = $todayScores->pluck('url')->unique()->count();
        
        $metrics = ['performance', 'accessibility', 'best_practices', 'seo'];
        foreach ($metrics as $metric) {
            $report['average_scores'][$metric] = round($todayScores->avg($metric), 2);
        }
        
        $yesterdayScores = \DB::table('lighthouse_scores')
            ->whereDate('created_at', Carbon::yesterday())
            ->get();
        
        if (!$yesterdayScores->isEmpty()) {
            foreach ($metrics as $metric) {
                $todayAvg = $report['average_scores'][$metric];
                $yesterdayAvg = round($yesterdayScores->avg($metric), 2);
                
                $report['trends'][$metric] = [
                    'today' => $todayAvg,
                    'yesterday' => $yesterdayAvg,
                    'change' => $todayAvg - $yesterdayAvg,
                    'trend' => $todayAvg > $yesterdayAvg ? 'up' : ($todayAvg < $yesterdayAvg ? 'down' : 'stable')
                ];
            }
        }
        
        return $report;
    }
}