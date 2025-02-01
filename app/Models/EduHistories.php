<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EduHistories extends Model
{
    protected $fillable = [
        'user_id',
        'stage',
        'name',
        'graduate_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
