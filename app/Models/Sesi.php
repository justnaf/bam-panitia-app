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
        'type',
        'grade',
        'cv_path',
        'materi_path',
        'status',
    ];
}
