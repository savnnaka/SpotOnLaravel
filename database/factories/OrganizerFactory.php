<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class OrganizerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fullname' => fake()->name(),
            'name' => fake()->word(),
            'email' => fake()->safeEmail(),
            'city' => 'Tübingen',
            'phone' => fake()->phoneNumber(),
            'password' => \Hash::make('hund1234'),
            'email_verified' => 1,
        ];
    }

}
