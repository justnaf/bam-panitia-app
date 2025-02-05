<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestRoom extends Model
{
    protected $fillable = [
        'event_id',
        'code',
        'name',
        'capacity',
        'gender'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function modelHasRestroom()
    {
        return $this->hasMany(ModelHasRestroom::class);
    }
}
