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


    /** @test */
    public function an_authenticated_user_can_visit_the_create_camp_view()
    {
        $this->signIn();

        $this->get('/camps/create')
            ->assertSee('Add Camp');
    }

    /** @test */
    public function unauthenticated_users_may_not_visit_the_create_camp_view()
    {
        $this->withExceptionHandling();

        $this->get('/camps/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_add_a_new_camp()
    {
        $this->signIn();

        $camp = make('App\Camp');
        $this->post('/camps', $camp->toArray());

        $this->get($camp->path())
            ->assertSee($camp->name);
    }

    /** @test */
    public function unauthenticated_users_may_not_add_new_camps()
    {
        $this->withExceptionHandling();

        $this->post('/camps', [])
            ->assertRedirect('/login');
    }
}
