<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCampsTest extends TestCase
{
    use DatabaseMigrations;

    protected $camp;
    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function authorised_users_can_view_all_their_camps()
    {
        $this->signIn($this->user);

        $this->get('/camps')
            ->assertSee($this->camp->name);
    }

    /** @test */
    public function unauthorised_users_may_not_view_camps()
    {
        // Not signed in
        $this->withExceptionHandling();

        $this->get('/camps')
            ->assertRedirect('/login');

        // Not the owner
        $this->signIn();

        $this->get('/camps')
            ->assertDontSee($this->camp->name);
    }

    /** @test */
    public function authorised_users_can_view_their_camp()
    {
        $this->signIn($this->user);

        $this->get('/camps/' . $this->camp->id)
            ->assertSee($this->camp->name);
    }

    /** @test */
    public function unauthorised_users_may_not_view_a_camp()
    {
        // Not signed in
        $this->withExceptionHandling();

        $this->get('/camps/' . $this->camp->id)
            ->assertRedirect('/login');

        // Not the owner
        $this->signIn();

        $this->get('/camps/' . $this->camp->id)
            ->assertStatus(403);
    }

    /** @test */
    public function authorised_users_can_see_campers_that_are_associated_with_their_camp()
    {
        $this->signIn($this->user);

        $camper = create('App\Camper', ['camp_id' => $this->camp->id]);

        $this->get($this->camp->path())
            ->assertSee($camper->name);
    }

    /** @test */
    public function authorised_users_can_see_cabins_that_are_associated_with_their_camp()
    {
        $this->signIn($this->user);

        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);

        $this->get($this->camp->path())
            ->assertSee($cabin->name);
    }

//    /** @test */
//    public function an_authenticated_user_can_request_all_campers_for_a_given_camp()
//    {
//        $this->signIn($this->user);
//
//        $camper = create('App\Camper', ['camp_id' => $this->camp->id]);
//
//        $uri = $this->camp->path() . '/campers';
//        $response = $this->getJson($uri)->json();
//
//        $this->assertCount(1, $response['data']);
//        $this->assertEquals($camper->name, $response['data'][0]['name']);
//    }

}
