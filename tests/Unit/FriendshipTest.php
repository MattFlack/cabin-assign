<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FriendshipTest extends TestCase
{
    use DatabaseMigrations;

    protected $camp;
    protected $camper;
    protected $friendOfCamper;
    protected $friendship;

    public function setUp()
    {
        parent::setUp();

        $this->camp = create('App\Camp');
        $this->camper = create('App\Camper', ['camp_id' => $this->camp->id]);
        $this->friendOfCamper = create('App\Camper', ['camp_id' => $this->camp->id]);

        $this->friendship = create('App\Friendship',
            [
                'camp_id' => $this->camp->id,
                'camper_id' => $this->camper->id,
                'friend_id' => $this->friendOfCamper->id
            ]);
    }

    /** @test */
    public function a_friendship_has_a_camper()
    {
        $this->assertEquals($this->camper->name, $this->friendship->camper->name);
    }

    /** @test */
    public function a_friendship_has_a_friend_of_camper()
    {
        $this->assertEquals($this->friendOfCamper->name, $this->friendship->friendOfCamper->name);
    }

    /** @test */
    public function a_friendship_has_a_path()
    {
        $this->assertEquals(
            $this->camper->path() . '/friendships/' . $this->friendship->id,
            $this->friendship->path()
        );
    }
}
