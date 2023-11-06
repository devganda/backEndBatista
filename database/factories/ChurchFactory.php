<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Church>
 */
class ChurchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'cnpj' => '00000000000',
            'address' => fake()->address(), 
            'UF' => 'GO',
            'date_inauguration' => fake()->date() 
        ];
    } 
}
