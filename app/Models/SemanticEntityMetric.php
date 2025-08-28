<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SemanticEntityMetric extends Model
{
    protected $fillable = [
        'entity_id',
        'metric_key',
        'metric_value',
        'metric_date'
    ];

    protected $casts = [
        'metric_value' => 'float',
        'metric_date' => 'date'
    ];

    /**
     * Get the semantic entity this metric belongs to
     */
    public function entity(): BelongsTo
    {
        return $this->belongsTo(SemanticEntity::class, 'entity_id', 'entity_id');
    }
}