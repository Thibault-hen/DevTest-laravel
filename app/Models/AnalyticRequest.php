<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AnalyticRequest extends Model
{
    use HasUuids;

    protected $table = 'analytics_requests';

    protected $fillable = [
        'route',
        'method',
        'duration_ms',
        'status_code',
        'user_agent',
        'user_id',
        'visitor_id',
        'session_id',
        'ip_address',
        'date',
    ];

    public $timestamps = false;
}
