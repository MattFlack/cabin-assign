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
            $this->createCampersWithRandomFriends($camp->id);
            $this->createCampersWithReciprocalFriends($camp->id);
        }
    }

    protected function createCampersWithRandomFriends($campId)
    {
        $campers = factory('App\Camper', DatabaseSeeder::NUM_CAMPERS_WITH_RANDOM_FRIENDS)->create(['camp_id' => $campId]);

        // Create friends for the campers

        foreach ($campers as $camper) {
            // Get random friend id's (any camper besides themselves)
            $friendIds = $campers->whereNotIn('id', $camper->id)->random(DatabaseSeeder::NUM_FRIENDS_PER_CAMPER)->map->id;

            foreach ($friendIds as $friend) {
                factory('App\Friendship')->create([
                    'camp_id' => $campId,
                    'camper_id' => $camper->id,
                    'friend_id' => $friend
                ]);
            }
        }
    }

    protected function createCampersWithReciprocalFriends($campId) {

        for($i = 0; $i < (DatabaseSeeder::NUM_CAMPERS_WITH_RECIPROCAL_FRIENDS / 2); $i++) {
            $campers = factory('App\Camper', 2)->create(['camp_id' => $campId]);

            factory('App\Friendship')->create([
                'camp_id' => $campId,
                'camper_id' => $campers[0],
                'friend_id' => $campers[1],
            ]);

            factory('App\Friendship')->create([
                'camp_id' => $campId,
                'camper_id' => $campers[1],
                'friend_id' => $campers[0],
            ]);

        }
    }

}
