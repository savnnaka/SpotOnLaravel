<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\OrganizerProfile;
use App\Models\Comment;

class User extends Authenticatable
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
     * 1 User can follow many OrganizerProfiles
     */
    public function following()
    {
        return $this->belongsToMany(OrganizerProfile::class);
    }

    /**
     * 1 User can like many Events
     */
    public function likings()
    {
        return $this->belongsToMany(Event::class);
    }

    // 1:n relationship User and Comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at','DESC');
    }

}
