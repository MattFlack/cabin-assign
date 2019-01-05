<?php

use Faker\Generator as Faker;

$factory->define(App\Friendship::class, function (Faker $faker) {
    return [
        'camp_id' => function () {
            return factory('App\Camp')->create()->id;
        },
        'camper_id' => function () {
            return factory('App\Camper')->create()->id;
        },
        'friend_id' => function () {
            return factory('App\Camper')->create()->id;
        }
    ];
});
