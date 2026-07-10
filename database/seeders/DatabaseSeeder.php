<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionTag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@email.com',
            'password'=> Hash::make('password'),
            'image'=>'default.png'
        ]);

        Tag::create([
            'name'=>'Web Dev',
            'slug'=>Str::slug('Web Dev'),
        ]);

        Tag::create([
            'name'=>'Web Desig',
            'slug'=>Str::slug('Web Desig'),
        ]);

        Tag::create([
            'name'=>'Mobile Dev',
            'slug'=>Str::slug('Mobile Dev'),
        ]);

        Question::create([
            'user_id'=>1,
            'slug'=>Str::slug('What is google ?'),
            'title'=>'What is google ?',
            'description'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum corrupti similique perferendis officiis sint illo rem, sit beatae voluptatum quibusdam.'
        ]);

        QuestionTag::create([
            'question_id'=>1,
            'tag_id'=>1
        ]);

        QuestionTag::create([
            'question_id'=>1,
            'tag_id'=>2
        ]);
    }
}
