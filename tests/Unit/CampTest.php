<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CampTest extends TestCase
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
    public function a_camp_can_have_campers()
    {
        $this->assertInstanceOf('App\Camper', $this->camp->campers[0]);
    }

    /** @test */
    public function a_camp_has_a_path()
    {
        $this->assertEquals('/camps/' . $this->camp->id, $this->camp->path());
    }

    /** @test */
    public function a_camp_can_have_friendships()
    {
        $friendOfCamper = create('App\Camper', ['camp_id' => $this->camp->id]);

        create('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->camper->id,
            'friend_id' => $friendOfCamper->id,
        ]);

        $this->assertInstanceOf('App\Friendship', $this->camp->friendships[0]);
    }
}
