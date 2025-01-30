<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'speaker',
        'room',
        'time',
        'type',
        'grade',
        'cv_path',
        'materi_path',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function grade()
    {
        return $this->hasMany(Grade::class);
    }
}
