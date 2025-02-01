<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresenceHistory extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'sesi_id',
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

    public function sesi()
    {
        return $this->belongsTo(Sesi::class);
    }
}
