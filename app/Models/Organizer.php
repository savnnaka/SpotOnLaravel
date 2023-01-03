<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Event;
use App\Models\OrganizerProfile;
use App\Models\Comments;

class Organizer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'city',
        'phone',
        'password',
        'email_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


        /**
     * We want to automatically create a profile for a newly registered organizer
     * fires an event once a Organizer instance was created
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($organizer) {
            $organizer->profile()->create([
                'name' => $organizer->name,
            ]);
        });
    }


    // 1:n relationship Organizer and Events
    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('created_at','DESC');
    }

    // 1:1 relationshiop Organizer and Profile
    public function profile()
    {
        return $this->hasOne(OrganizerProfile::class);
    }

    // get events that still lie in the future only
    public function futureEvents()
    {
        return $this->hasMany(Event::class)->where('date', '>', now())->orderBy('date','ASC');
    }

    // get events that still lie in the future only
    public function pastEvents()
    {
        return $this->hasMany(Event::class)->where('date', '<', now())->orderBy('date','ASC');
    }

}
