<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrgHistories extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'position',
        'period',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
