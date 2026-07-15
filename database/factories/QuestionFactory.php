<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title =$this->faker->sentence(5);
        return [
            
            'user_id'=>$this->faker->randomElement([1, 2]),
            'title'=>$title,
            'slug'=>Str::slug($title),
            'description'=>$this->faker->text(100)
        ];
    }
}
