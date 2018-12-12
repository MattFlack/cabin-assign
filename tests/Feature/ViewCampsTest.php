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

        $this->user = factory('App\User')->create();
        $this->camp = factory('App\Camp')->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function an_authenticated_user_can_view_all_their_camps()
    {
        $this->be($this->user);

        $this->get('/camps')
            ->assertSee($this->camp->name);
    }

    /** @test */
    public function an_authenticated_user_can_view_a_camp()
    {
        $this->be($this->user);

        $this->get('/camps/' . $this->camp->id)
            ->assertSee($this->camp->name);
    }

    /** @test */
    public function an_authenticated_user_can_see_campers_that_are_associated_with_a_camp()
    {
        $this->be($this->user);

        $camper = factory('App\Camper')->create(['camp_id' => $this->camp->id]);

        $this->get('/camps/' . $this->camp->id)
            ->assertSee($camper->name);
    }

    /** @test */
    public function unauthenticated_users_may_not_view_camps()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/camps');
    }

    /** @test */
    public function unauthenticated_users_may_not_view_a_camp()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/camps/' . $this->camp->id);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_other_users_camps()
    {
        $anotherUser = factory('App\User')->create();
        $this->be($anotherUser);

        $this->get('/camps')
            ->assertDontSee($this->camp->name);
    }

    /** @test */
    public function an_authenticated_user_may_not_view_other_users_camp()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $anotherUser = factory('App\User')->create();
        $this->be($anotherUser);

        $this->get('/camps/' . $this->camp->id);
    }

}
