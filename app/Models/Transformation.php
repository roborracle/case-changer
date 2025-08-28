<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'transformation_type',
        'input_text',
        'output_text',
        'user_ip',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get recent transformations by type
     */
    public static function getRecentByType(string $type, int $limit = 10)
    {
        return static::where('transformation_type', $type)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get popular transformation types
     */
    public static function getPopularTypes(int $limit = 10)
    {
        return static::selectRaw('transformation_type, COUNT(*) as usage_count')
            ->groupBy('transformation_type')
            ->orderBy('usage_count', 'desc')
            ->limit($limit)
            ->get();
    }
}