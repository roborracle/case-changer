<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ValidationLog;

class ValidationLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ValidationLog::query();

        if ($request->has('tool_name')) {
            $query->where('tool_name', $request->input('tool_name'));
        }

        if ($request->has('severity')) {
            $query->where('severity', $request->input('severity'));
        }

        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->input('start_date'));
        }

        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->input('end_date'));
        }

        return $query->paginate(100);
    }

    public function stats(Request $request)
    {
        $total = ValidationLog::count();
        $errors = ValidationLog::where('severity', 'error')->count();

        return response()->json([
            'total_logs' => $total,
            'error_logs' => $errors,
            'error_rate' => $total > 0 ? ($errors / $total) * 100 : 0,
        ]);
    }
}
