<?php

use Faker\Generator as Faker;

$factory->define(App\Camp::class, function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create()->id;
        },
        'name' => 'Camp '.$faker->city
    ];
});
