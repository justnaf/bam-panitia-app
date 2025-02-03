<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    protected $fillable = [
        'user_id',
        'common',
        'etc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
