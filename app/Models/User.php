<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function modelRequestRole()
    {
        return $this->hasMany(ModelRequestRole::class);
    }
    public function event()
    {
        return $this->hasMany(Event::class);
    }
    public function modelActiveEvent()
    {
        return $this->hasMany(ModelActiveEvent::class);
    }

    public function modelHistoryEvent()
    {
        return $this->hasMany(ModelHistoryEvent::class);
    }

    public function presenceHistory()
    {
        return $this->hasMany(PresenceHistory::class);
    }

    public function presenceHistories()
    {
        return $this->hasMany(PresenceHistory::class);
    }
    public function grade()
    {
        return $this->hasMany(Grade::class);
    }

    // Detail Of User
    public function dataDiri()
    {
        return $this->hasOne(DataDiri::class);
    }

    public function EduHistories()
    {
        return $this->hasMany(EduHistories::class);
    }

    public function OrgHistories()
    {
        return $this->hasMany(OrgHistories::class);
    }

    public function OwnPaper()
    {
        return $this->hasMany(OwnPaper::class);
    }

    public function ReadInterest()
    {
        return $this->hasMany(ReadInterest::class);
    }
    // end Detail Of User
}
