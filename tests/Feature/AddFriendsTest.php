<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AddFriendsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $camp;
    protected $camper;
    protected $anotherCamper;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
        $this->camper = create('App\Camper', ['camp_id' => $this->camp->id]);
        $this->anotherCamper = create('App\Camper', ['camp_id' => $this->camp->id]);
    }

    /** @test */
    public function an_authenticated_user_can_visit_the_add_friend_view()
    {
        $this->signIn($this->user);

        $this->get($this->camper->path())
            ->assertStatus(200)
            ->assertSee($this->camper->name);
    }

    /** @test */
    public function unauthenticated_users_may_not_visit_the_add_friend_view()
    {
        $this->withExceptionHandling();

        $this->get($this->camper->path())
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_may_not_visit_the_add_friend_view_page_for_a_camp_that_do_not_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->get($this->camper->path())
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_specify_a_friend_for_a_given_camper()
    {
        $this->signIn($this->user);

        $friend = make('App\Friend',
            [
                'camper_id' => $this->camper->id,
                'friend_id' => $this->anotherCamper->id
            ]);

        $this->post($this->camper->path(), $friend->toArray());

        $this->get($this->camper->path())
            ->assertSee('New friend added')
            ->assertSee("Friends: 1");
    }

    /** @test */
    public function unauthenticated_users_may_not_specify_a_friend()
    {
        $this->withExceptionHandling();

        $this->post($this->camper->path(), [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function duplicate_friends_may_not_be_added()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->signIn($this->user);

        $friend = create('App\Friend',
            [
                'camper_id' => $this->camper->id,
                'friend_id' => $this->anotherCamper->id
            ]);

        $this->post($this->camper->path(), $friend->toArray());
    }
}
