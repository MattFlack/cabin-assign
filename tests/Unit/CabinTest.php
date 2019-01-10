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
}
