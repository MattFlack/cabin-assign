<?php

namespace Tests\Feature;

use App\Friendship;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ManageCampersTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $camp;
    protected $camper;
    protected $anotherCamper;
    protected $friendship;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
        $this->camper = create('App\Camper', ['camp_id' => $this->camp->id]);
        $this->anotherCamper = create('App\Camper', ['camp_id' => $this->camp->id]);
        $this->friendship = create('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->camper->id,
            'friend_id' => $this->anotherCamper->id
        ]);
    }

    /** @test */
    public function guests_cannot_manage_campers()
    {
        $this->withExceptionHandling();

        $this->get($this->camper->path())->assertRedirect('/login');
        $this->post($this->camp->path().'/campers', [])->assertRedirect('/login');
        $this->json('DELETE', $this->camper->path())->assertStatus(401);

        // Campers Friends
        $this->post($this->camper->path(), [])->assertRedirect('/login');
        $this->json('DELETE', $this->friendship->path())->assertStatus(401);
    }


    /** @test */
    public function a_user_can_add_a_camper_to_one_of_their_camps()
    {
        $this->signIn($this->user);

        $this->post($this->camp->path().'/campers', $this->camper->toArray());

        $this->assertDatabaseHas('campers', $this->camper->toArray());

        $this->get($this->camp->path(). '/campers/create')
            ->assertSee(e($this->camper->name));
    }

    /** @test */
    public function a_user_can_view_one_of_their_campers()
    {
        $this->signIn($this->user);

        $this->get($this->camper->path())
            ->assertStatus(200)
            ->assertSee(e($this->camper->name));
    }

    /** @test */
    public function a_user_may_not_view_a_camper_that_is_not_theirs()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->get($this->camper->path())
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_delete_their_camper()
    {
        $this->signIn($this->user);

        $this->json('DELETE', $this->camper->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('campers', [ 'name' => $this->camper->name ]);
        $this->assertDatabaseMissing('friendships', $this->friendship->toArray());
    }

    /** @test */
    public function users_may_not_delete_campers_they_dont_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->json('DELETE', $this->camper->path())
            ->assertStatus(403);
    }

    /** @test */
    public function deleting_a_camper_also_deletes_all_friendships_camper_is_involved_in()
    {
        $this->signIn($this->user);

        $oppositeFriendship = create('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->anotherCamper->id,
            'friend_id' => $this->camper->id,
        ]);

        $this->json('DELETE', $this->camper->path());

        $this->assertDatabaseMissing('friendships', $this->friendship->toArray());
        $this->assertDatabaseMissing('friendships', $oppositeFriendship->toArray());
    }

    /** @test */
    public function a_user_can_specify_a_friend_for_one_of_their_campers()
    {
        $this->signIn($this->user);

        $friendship = make('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->anotherCamper->id,
            'friend_id' => $this->camper->id,
        ]);

        $this->post($this->anotherCamper->path(), $friendship->toArray());

        $this->assertDatabaseHas('friendships', $friendship->toArray());

        $this->get($this->anotherCamper->path())
            ->assertSee('New friend added')
            ->assertSee("Total: 1");
    }

    /** @test */
    public function duplicate_friends_may_not_be_added()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->signIn($this->user);

        $friend = create('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->camper->id,
            'friend_id' => $this->anotherCamper->id
        ]);

        $this->post($this->camper->path(), $friend->toArray());
    }

    /** @test */
    public function a_user_can_delete_a_friendship_of_one_of_their_campers()
    {
        $this->signIn($this->user);

        $this->json('DELETE', $this->friendship->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('friendships', ['id' => $this->friendship->id]);
    }

    /** @test */
    public function users_may_not_delete_friendships_of_campers_they_do_not_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->json('DELETE', $this->friendship->path())
            ->assertStatus(403);

        $this->assertDatabaseHas('friendships', ['id' => $this->friendship->id]);
    }
}
