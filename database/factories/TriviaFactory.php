<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Trivia;

$factory->define(Trivia::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence,
        'answer' => $faker->sentence
    ];
});
