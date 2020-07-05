<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Property::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'value' => $faker->randomDigit % 2 == 0 ? $faker->randomDigit : $faker->word
    ];
});
