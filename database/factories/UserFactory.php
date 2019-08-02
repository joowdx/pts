<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $sex = $faker->randomElement(['male', 'female']);
    return [
        'icon' => '/storage/img/user/avatars/00000-000000000'.substr($sex, 0, 1).'.png',
        'name' => $faker->name($sex),
        'username' => substr($faker->unique()->userName, 0, 12),
        'description' => substr($faker->sentence(), 0, 60),
        'sex' => $sex,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => $faker->randomElement([now(), null]),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'type' => $faker->randomElement(['moderator', 'admin', 'general']),
        'added_by' => $faker->randomElement([1, 2, 3]),
    ];
});
