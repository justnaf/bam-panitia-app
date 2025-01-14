<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataDiri extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'address',
        'birth_date',
        'birth_place',
        'phone_number',
        'profile_picture'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
