<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelActiveEvent extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'isJoin',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
