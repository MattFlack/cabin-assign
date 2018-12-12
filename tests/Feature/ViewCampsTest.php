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
    public function an_authenticated_user_can_view_all_their_camps()
    {
//        $this->be($this->user);
        $this->signIn($this->user);

        $this->get('/camps')
            ->assertSee($this->camp->name);
    }

    /** @test */
    public function unauthenticated_users_may_not_view_camps()
    {
        $this->withExceptionHandling();

        $this->get('/camps')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_view_a_camp()
    {
        $this->signIn($this->user);

        $this->get('/camps/' . $this->camp->id)
            ->assertSee($this->camp->name);
    }

    /** @test */
    public function unauthenticated_users_may_not_view_a_camp()
    {
        $this->withExceptionHandling();

        $this->get('/camps/' . $this->camp->id)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_see_campers_that_are_associated_with_a_camp()
    {
        $this->signIn($this->user);

        $camper = create('App\Camper', ['camp_id' => $this->camp->id]);

        $this->get('/camps/' . $this->camp->id)
            ->assertSee($camper->name);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_other_users_camps()
    {
        $this->signIn();

        $this->get('/camps')
            ->assertDontSee($this->camp->name);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_another_users_camp()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->get('/camps/' . $this->camp->id)
            ->assertStatus(403);
    }

}
