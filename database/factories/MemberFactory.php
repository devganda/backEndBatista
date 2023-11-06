<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return  [
            'church_id' => 1,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'age' => fake()->year(),
            'date_admission_church' => fake()->date(),
            'phone' => fake()->phoneNumber(),
            'UF' => 'GO',
            'address' => fake()->address()
        ];
    }
}
