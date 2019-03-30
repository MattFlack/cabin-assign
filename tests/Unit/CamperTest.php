<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CamperTest extends TestCase
{
    use DatabaseMigrations;

    protected $camp;
    protected $camper;

    public function setUp()
    {
        parent::setUp();

        $this->camp = create('App\Camp');
        $this->camper = create('App\Camper', ['camp_id' => $this->camp->id]);
    }

    /** @test */
    public function a_camper_has_a_camp()
    {
        $this->assertInstanceOf('App\Camp', $this->camper->camp);
    }

    /** @test */
    public function a_camper_has_a_path()
    {
        $this->assertEquals(
            $this->camp->path() . '/campers/' . $this->camper->id,
            $this->camper->path());
    }

    /** @test */
    public function a_camper_has_friends()
    {
        $friend = create('App\Friendship', ['camper_id' => $this->camper->id]);

        $this->assertInstanceOf('App\Friendship', $this->camper->friends[0]);
        $this->assertEquals($friend->friend_id, $this->camper->friends[0]->friend_id);
        $this->assertEquals($friend->camper_id, $this->camper->friends[0]->camper_id);
    }

    /** @test */
    public function a_camper_can_have_a_cabin()
    {
        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);

        $cabin->addCamper($this->camper);

        $this->assertInstanceOf('App\Cabin', $this->camper->cabin);
    }

    /** @test */
    public function a_camper_knows_if_it_has_a_cabin()
    {
        $this->assertFalse($this->camper->hasCabin());

        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);
        $camperWithCabin = create('App\Camper', ['cabin_id' => $cabin->id]);

        $this->assertTrue($camperWithCabin->hasCabin());
    }

    /** @test */
    public function a_camper_knows_if_it_has_at_least_one_friend()
    {
        $this->assertFalse($this->camper->hasFriend());

        create('App\Friendship', ['camper_id' => $this->camper->id]);

        $this->assertTrue($this->camper->fresh()->hasFriend());
    }
}
