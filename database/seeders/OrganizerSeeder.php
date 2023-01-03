<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organizer;
use App\Models\OrganizerProfile;
use App\Models\Event;
use App\Models\Comment;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organizer::factory(10)->create()
            ->each(function ($organizer) {
                OrganizerProfile::factory(1)->create(['organizer_id' => $organizer->id]);
                Event::factory(10)->create(['organizer_id' => $organizer->id])
                ->each(function ($event){
                    Comment::factory(3)->create(['event_id' => $event->id]);
                });
                }
            );
    }
}
