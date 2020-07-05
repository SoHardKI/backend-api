<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat(2, 1, 99999),
        'count' => $faker->randomDigit,
    ];
});
