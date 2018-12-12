<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CampTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_camp_can_have_campers()
    {
        $camp = create('App\Camp');

        create('App\Camper', ['camp_id' => $camp->id]);

        $this->assertInstanceOf('App\Camper', $camp->campers[0]);
    }
}
