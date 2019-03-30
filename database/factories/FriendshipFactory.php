<?php

use Faker\Generator as Faker;

$factory->define(App\Friendship::class, function (Faker $faker) {
    return [
        'camp_id' => function () {
            return factory('App\Camp')->create()->id;
        },
        'camper_id' => function (array $friendship) {
            return factory('App\Camper')->create(['camp_id' => $friendship['camp_id']])->id;
        },
        'friend_id' => function (array $friendship) {
            $camp = App\Camp::find($friendship['camp_id']);

            if($camp->campers->count() > 1) {

                while (true) {
                    $camper = $camp->campers->random();

                    if ($camper->id !== $friendship['camper_id']) {
                        return $camper->id;
                    }
                }
                return $camp->campers->random()->id;
            }

            return factory('App\Camper')->create(['camp_id' => $friendship['camp_id']])->id;
        }
    ];
});
