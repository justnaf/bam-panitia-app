<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnPaper extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'publish_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
