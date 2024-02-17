<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Redirect extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'status',
        'url_redirect',
    ];

    protected $appends = ['code'];

    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RedirectLog::class);
    }

    public function getCodeAttribute(): string
    {
        return Hashids::encode($this->getAttribute('id'));
    }
}
