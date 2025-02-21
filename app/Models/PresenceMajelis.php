<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresenceMajelis extends Model
{
    protected $fillable = [
        'majelis_id',
        'user_id_presenced',
        'user_id_presencer',
        'desc',
        'status',
        'resume',
    ];

    public function presencedUser()
    {
        return $this->belongsTo(User::class, 'user_id_presenced');
    }

    public function presencerUser()
    {
        return $this->belongsTo(User::class, 'user_id_presencer');
    }

    public function majelis()
    {
        return $this->belongsTo(Majelis::class, 'majelis_id');
    }
}
