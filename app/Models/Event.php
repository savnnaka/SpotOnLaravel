<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    /** every event is hosted by 1 organizer */
    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * returns saved image of event, if available
     * else, returns default image
     */
    public function image()
    {
        return ($this->image) ? $this->image : ("data:image/png;base64, " . base64_encode(file_get_contents("storage/default_images/event.jpg")));
    }

    /**
     * returns first 200 characters of description for previews
     */
    public function shortDescription()
    {
        return mb_substr($this->description, 0, 199);
    }


    /**
     * An Event has many likes
     */
    public function likes()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * An Event has many comments
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at','DESC');
    }



}
