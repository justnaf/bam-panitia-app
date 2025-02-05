<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelHasRestroom extends Model
{
    protected $fillable = [
        'event_id',
        'user_id',
        'rest_room_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function restRoom()
    {
        return $this->belongsTo(RestRoom::class);
    }
}
