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

    /** @test */
    public function a_camp_can_have_cabins()
    {
        create('App\Cabin', ['camp_id' => $this->camp->id]);

        $this->assertInstanceOf('App\Cabin', $this->camp->cabins[0]);
    }

    /** @test */
    public function a_camp_may_have_unallocated_campers()
    {
        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);

        $this->assertInstanceOf('App\Camper', $this->camp->unallocatedCampers[0]);
        $this->assertEquals($this->camper->name, $this->camp->unallocatedCampers[0]->name);

        $cabin->addCamper($this->camper);

        $this->assertEmpty($this->camp->fresh()->unallocatedCampers);
    }

    /** @test */
    public function a_camp_can_deallocate_all_campers_cabins()
    {
        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);
        $camper = create('App\Camper', ['camp_id' => $this->camp->id]);
        $camper2 = create('App\Camper', ['camp_id' => $this->camp->id]);

        $cabin->addCamper($this->camper);
        $cabin->addCamper($camper);
        $cabin->addCamper($camper2);

        $this->assertEquals(0, $this->camp->unallocatedCampers->count());

        $this->camp->deallocateCabins();

        $this->assertEquals(3, $this->camp->fresh()->unallocatedCampers->count());
    }



//    /** @test */
//    public function a_camp_can_allocate_cabins_to_campers()
//    {
//
//    }
}
