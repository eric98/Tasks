<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'name'        => $faker->word,
        'description' => $faker->paragraph,
        'user_id'     => factory(User::class)->create()->id,
        'completed'   => false,
    ];
});

$factory->state(App\Task::class, 'completed', [
    'completed' => 'completed',
]);
