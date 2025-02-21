<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'location',
        'location_url',
        'start_date',
        'end_date',
        'institution',
        'max_person',
        'pic',
        'email',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modelRequestEvent()
    {
        return $this->hasOne(ModelRequestEvent::class);
    }

    public function sesi()
    {
        return $this->hasMany(Sesi::class);
    }
    public function grade()
    {
        return $this->hasMany(Grade::class);
    }

    public function modelActiveEvent()
    {
        return $this->hasMany(ModelActiveEvent::class);
    }

    public function modelHistoryEvent()
    {
        return $this->hasMany(ModelHistoryEvent::class);
    }

    public function presenceHistories()
    {
        return $this->hasMany(PresenceHistory::class);
    }

    public function restRoom()
    {
        return $this->hasMany(RestRoom::class);
    }
    public function modelHasRestroom()
    {
        return $this->hasMany(ModelHasRestroom::class);
    }
}
