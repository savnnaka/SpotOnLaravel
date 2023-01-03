<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organizer;
use App\Models\User;

class OrganizerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'contact',
        'image',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * A profile has many followers
     */
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * returns profile image
     * if no image is set yet, returns default image
     */
    public function profileImage()
    {
        return ($this->image) ? $this->image : base64_encode(file_get_contents("storage/default_images/profile.jpg"));
    }
}
