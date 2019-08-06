<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Judge;
use Faker\Generator as Faker;

$factory->define(Judge::class, function (Faker $faker) {
  return [
    'name' => $faker->name(),
    'pin' => $faker->randomNumber(6, true),
    'token' => Str::random(12),
  ];
});
