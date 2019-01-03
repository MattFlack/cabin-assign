<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FriendTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_friend_has_a_camper()
    {
        $camp = create('App\Camp');
        $camper = create('App\Camper', ['camp_id' => $camp->id]);
        $friendOfCamper = create('App\Camper', ['camp_id' => $camp->id]);

        $friendship = create('App\Friend',
            [
                'camper_id' => $camper->id,
                'friend_id' => $friendOfCamper->id
            ]);

        $this->assertEquals($camper->name, $friendship->camper->name);
        $this->assertEquals($friendOfCamper->name, $friendship->friendOfCamper->name);
    }
}
