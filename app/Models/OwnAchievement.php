<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnAchievement extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'achieve_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
