<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CampTest extends TestCase
{
    use DatabaseMigrations;

    protected $camp;

    public function setUp()
    {
        parent::setUp();

        $this->camp = create('App\Camp');
    }

    /** @test */
    public function a_camp_can_have_campers()
    {
        create('App\Camper', ['camp_id' => $this->camp->id]);

        $this->assertInstanceOf('App\Camper', $this->camp->campers[0]);
    }

    /** @test */
    public function a_camp_has_a_path()
    {
        $this->assertEquals('/camps/' . $this->camp->id, $this->camp->path());
    }
}
