<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CabinTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_cabin_has_a_path()
    {
        $cabin = create('App\Cabin');

        $this->assertEquals('/camps/' . $cabin->camp_id . '/cabins/' . $cabin->id, $cabin->path());
    }

    /** @test */
    public function a_cabin_can_add_a_camper()
    {
        $cabin = create('App\Cabin', ['number_of_beds' => 1]);
        $camper = create('App\Camper');

        $wasAdded = $cabin->addCamper($camper);

        $this->assertTrue($wasAdded);

        $this->assertEquals($cabin->id, $camper->cabin_id);

        $this->assertEquals($camper->name, $cabin->fresh()->campers[0]->name);
    }

    /** @test */
    public function a_cabin_will_not_add_a_camper_to_a_full_cabin()
    {
        $cabin = create('App\Cabin', ['name' => 'Small Cabin', 'number_of_beds' => 1]);
        $camper = create('App\Camper');
        $anotherCamper = create('App\Camper');

        $cabin->addCamper($camper);

        $wasAdded = $cabin->fresh()->addCamper($anotherCamper);

        $this->assertFalse($wasAdded);

        $this->assertNull($anotherCamper->cabin_id);
    }

    /** @test */
    public function a_cabin_can_remove_a_camper()
    {
        $cabin = create('App\Cabin', ['name' => 'Small Cabin', 'number_of_beds' => 1]);
        $camper = create('App\Camper');
        $cabin->addCamper($camper);

        $cabin->refresh();
        $this->assertEquals($cabin->id, $camper->cabin_id);

        $cabin->removeCamper($camper);

        $this->assertNull($camper->fresh()->cabin_id);
    }

    /** @test */
    public function a_cabin_can_remove_all_campers()
    {
        $cabin = create('App\Cabin');
        $camper = create('App\Camper');
        $camper2 = create('App\Camper');

        $cabin->addCamper($camper);
        $cabin->addCamper($camper2);

        $cabin->refresh();
        $this->assertEquals($cabin->id, $camper2->cabin_id);
        $this->assertEquals($cabin->id, $camper2->cabin_id);

        $cabin->removeAllCampers();

        $this->assertNull($camper->fresh()->cabin_id);
        $this->assertNull($camper2->fresh()->cabin_id);
    }


    /** @test */
    public function a_cabin_can_have_campers()
    {
        $cabin = create('App\Cabin');
        create('App\Camper', ['cabin_id' => $cabin->id]);

        $this->assertInstanceOf('App\Camper', $cabin->campers[0]);
    }


    /** @test */
    public function a_cabin_has_an_available_bed_count()
    {
        $cabin = create('App\Cabin', ['number_of_beds' => 20]);

        $this->assertEquals(20, $cabin->availableBeds());

        create('App\Camper', ['cabin_id' => $cabin->id]);

        $this->assertEquals(19, $cabin->fresh()->availableBeds());
    }

}
