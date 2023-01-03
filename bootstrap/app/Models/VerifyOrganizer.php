<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organizer;

class VerifyOrganizer extends Model
{
    use HasFactory;

    public $table = "verify_organizers";

    protected $fillable = [
        'organizer_id',
        'token',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

}
