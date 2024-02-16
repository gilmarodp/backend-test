<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'redirect_id',
        'ip_address',
        'user_agent',
        'header_refer',
        'query_params',
        'accessed_at',
    ];

    protected $dateFormat = 'Y-m-d H:i:s';

    public $timestamps = false;

    public function redirect(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RedirectLog::class);
    }
}
