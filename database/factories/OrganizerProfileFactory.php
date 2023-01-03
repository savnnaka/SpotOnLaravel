<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrganizerProfile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrganizerProfile>
 */
class OrganizerProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'contact' => fake()->email(),
        ];
    }
}
