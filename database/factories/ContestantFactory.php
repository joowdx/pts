<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Contestant;
use Faker\Generator as Faker;

$factory->define(Contestant::class, function (Faker $faker) {
    return [
      'name' => $faker->name(),
      'number' => $faker->randomNumber(2),
    ];
});
