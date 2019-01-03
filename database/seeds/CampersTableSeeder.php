<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampersTableSeeder extends Seeder
{
    /**
     * Creates campers along with their friends relationship.
     *
     * @return void
     */
    public function run()
    {
        $camps = App\Camp::all();

        foreach ($camps as $camp) {
            $this->createCampers($camp->id);
        }
    }

    protected function createCampers($campId)
    {
        $campers = factory('App\Camper', DatabaseSeeder::NUM_CAMPERS_PER_CAMP)->create(['camp_id' => $campId]);

        // Create friends for the campers
        foreach ($campers as $camper) {

            // Get random friend id's (any camper besides themselves)
            $friendIds = $campers->whereNotIn('id', $camper->id)->random(DatabaseSeeder::NUM_FRIENDS_PER_CAMPER)->map->id;

            foreach ($friendIds as $friend) {
                DB::table('friendships')->insert([
                    'camper_id' => $camper->id,
                    'friend_id' => $friend,
                ]);
            }
        }
    }
}
