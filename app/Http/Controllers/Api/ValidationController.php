<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ValidationService;
use App\Services\TransformationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ValidationController extends Controller
{
    private ValidationService $validationService;
    
    public function __construct()
    {
        $transformationService = new TransformationService();
        $this->validationService = new ValidationService($transformationService);
    }
    
    /**
     * Get current validation status
     */
    public function status(): JsonResponse
    {
        $status = $this->validationService->getCurrentStatus();
        
        return response()->json([
            'data' => $status,
            'error' => null
        ]);
    }
    
    /**
     * Validate specific tool
     */
    public function validateTool(Request $request, string $tool): JsonResponse
    {
        try {
            $transformationService = new TransformationService();
            $transformations = $transformationService->getTransformations();
            
            if (!isset($transformations[$tool])) {
                return response()->json([
                    'data' => null,
                    'error' => [
                        'message' => "Tool '{$tool}' not found",
                        'code' => 'TOOL_NOT_FOUND'
                    ]
                ], 404);
            }
            
            $result = $this->validationService->validateTool($tool, $transformations[$tool]);
            
            return response()->json([
                'data' => $result,
                'error' => null
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'error' => [
                    'message' => 'Validation failed: ' . $e->getMessage(),
                    'code' => 'VALIDATION_ERROR'
                ]
            ], 500);
        }
    }
    
    /**
     * Run full validation (requires authentication or rate limiting in production)
     */
    public function validateAll(Request $request): JsonResponse
    {
        try {
            if (Cache::get('validation:running', false)) {
                return response()->json([
                    'data' => null,
                    'error' => [
                        'message' => 'Validation is already running',
                        'code' => 'VALIDATION_IN_PROGRESS'
                    ]
                ], 429);
            }
            
            
            $results = $this->validationService->validateAllTools();
            
            Cache::forget('validation:running');
            
            return response()->json([
                'data' => $results,
                'error' => null
            ]);
            
        } catch (\Exception $e) {
            Cache::forget('validation:running');
            
            return response()->json([
                'data' => null,
                'error' => [
                    'message' => 'Validation failed: ' . $e->getMessage(),
                    'code' => 'VALIDATION_ERROR'
                ]
            ], 500);
        }
    }
    
    /**
     * Get validation history for a tool
     */
    public function history(Request $request, string $tool): JsonResponse
    {
        $days = $request->input('days', 30);
        
        try {
            $history = $this->validationService->getToolValidationHistory($tool, $days);
            
            return response()->json([
                'data' => [
                    'tool' => $tool,
                    'days' => $days,
                    'history' => $history
                ],
                'error' => null
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'data' => null,
                'error' => [
                    'message' => 'Failed to retrieve history: ' . $e->getMessage(),
                    'code' => 'HISTORY_ERROR'
                ]
            ], 500);
        }
    }
    
    /**
     * Get latest validation certificate
     */
    public function certificate(): JsonResponse
    {
        $certificateDir = storage_path('app/validation/certificates/');
        
        if (!file_exists($certificateDir)) {
            return response()->json([
                'data' => null,
                'error' => [
                    'message' => 'No certificates found',
                    'code' => 'NO_CERTIFICATES'
                ]
            ], 404);
        }
        
        $certificates = glob($certificateDir . '*.json');
        
        if (empty($certificates)) {
            return response()->json([
                'data' => null,
                'error' => [
                    'message' => 'No certificates found',
                    'code' => 'NO_CERTIFICATES'
                ]
            ], 404);
        }
        
        $latestCert = end($certificates);
        $certificate = json_decode(file_get_contents($latestCert), true);
        
        return response()->json([
            'data' => $certificate,
            'error' => null
        ]);
    }
}