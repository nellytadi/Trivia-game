<?php

use Illuminate\Database\Seeder;

class TriviaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trivia')->insert([
            'question' => Str::random(30),
            'answer' => Str::random(6)
        ]);
    }
}
