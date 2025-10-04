<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    protected $fillable = [
        'query',
        'ip_address',
        'user_agent',
        'user_id',
        'total_results',
        'results_breakdown',
        'page',
        'per_page',
        'response_time',
    ];

    protected $casts = [
        'results_breakdown' => 'array',
        'response_time' => 'decimal:2',
    ];
}
