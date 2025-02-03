<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergic extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'desc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
