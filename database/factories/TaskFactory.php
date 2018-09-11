<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'status' => function () {
            return factory(App\TaskStatus::class)->create()->name;
        },
        'creator_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'executor_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});
