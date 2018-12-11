<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCampsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\User')->create();

    }

    /** @test */
    public function an_authenticated_user_can_visit_the_create_camp_view()
    {
        $this->be($this->user);

        $this->get('/camps/create')
            ->assertSee('Add Camp');
    }

    /** @test */
    public function unauthenticated_users_may_not_visit_the_create_camp_view()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/camps/create');
    }

    /** @test */
    public function an_authenticated_user_can_add_a_new_camp()
    {
        $this->be($this->user);

        $camp = factory('App\Camp')->make();
        $this->post('/camps', $camp->toArray());

        $this->get($camp->path())
            ->assertSee($camp->name);
    }

    /** @test */
    public function unauthenticated_users_may_not_add_new_camps()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/camps', []);
    }
}
