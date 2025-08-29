<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Services\TransformationService;

class HealthCheckController extends Controller
{
    public function __invoke()
    {
        $checks = [
            'application' => 'healthy',
            'database' => $this->checkDatabase(),
            'redis' => $this->checkRedis(),
            'transformation_service' => 'healthy',
            'last_deployment' => env('APP_LAST_DEPLOYMENT', 'N/A'),
            'version' => config('app.version', 'N/A'),
            'tool_availability' => count(app(TransformationService::class)->getTransformations()) . '/172',
        ];

        $status = in_array('unhealthy', $checks) ? 503 : 200;

        return response()->json($checks, $status);
    }

    private function checkDatabase(): string
    {
        try {
            DB::connection()->getPdo();
            return 'healthy';
        } catch (\Exception $e) {
            return 'unhealthy';
        }
    }

    private function checkRedis(): string
    {
        try {
            Redis::connection()->ping();
            return 'healthy';
        } catch (\Exception $e) {
            return 'unhealthy';
        }
    }
}
