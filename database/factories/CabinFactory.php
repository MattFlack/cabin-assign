<?php

use Faker\Generator as Faker;

$factory->define(App\Cabin::class, function (Faker $faker) {
    return [
        'camp_id' => function() {
            return factory('App\Camp')->create()->id;
        },
        'name' => $faker->name,
        'number_of_beds' => 10
    ];
});
