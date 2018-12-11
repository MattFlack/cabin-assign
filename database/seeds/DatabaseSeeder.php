<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    const NUM_USERS = 5;
    const NUM_CAMPS_PER_USER = 2;
    const NUM_CAMPERS_PER_CAMP = 50;
    const NUM_FRIENDS_PER_CAMPER = 3;

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
        ]);
    }
}
