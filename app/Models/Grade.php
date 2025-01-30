<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'sesi_id',
        'poin_1',
        'poin_2',
        'poin_3',
        'poin_4',
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
