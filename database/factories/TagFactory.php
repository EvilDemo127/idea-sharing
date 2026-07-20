<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement(['Web Dev', 'Mobile Dev', 'Web Design']);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name), 
        ];
    }
}
