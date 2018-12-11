<?php

use Illuminate\Database\Seeder;

class CampsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();

        foreach ($users as $user) {
            factory('App\Camp', DatabaseSeeder::NUM_CAMPS_PER_USER)->create(['user_id' => $user->id]);
        }
    }
}
