<?php

use Illuminate\Database\Seeder;

class CabinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camps = App\Camp::all();

        foreach ($camps as $camp) {
            factory('App\Cabin', DatabaseSeeder::NUM_CABINS_PER_CAMP)->create([
                'camp_id' => $camp->id,
                'number_of_beds' => DatabaseSeeder::NUM_BEDS_PER_CABIN,
            ]);
        }
    }
}
