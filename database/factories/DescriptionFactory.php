<?php

use Faker\Generator as Faker;

$factory->define(App\Description::class, function (Faker $faker) {
    return [
        'body' => $faker->text
    ];
});
