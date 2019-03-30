<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    const NUM_USERS = 5;
    const NUM_CAMPS_PER_USER = 2;
    const NUM_CAMPERS_WITH_RANDOM_FRIENDS = 30;
    const NUM_CAMPERS_WITH_RECIPROCAL_FRIENDS = 20;
    const NUM_FRIENDS_PER_CAMPER = 3;
    const NUM_CABINS_PER_CAMP = 5;
    const NUM_BEDS_PER_CABIN = 15;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CampsTableSeeder::class,
            CampersTableSeeder::class,
            CabinsTableSeeder::class,
        ]);
    }
}
