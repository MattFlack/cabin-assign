<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateCampsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $camp;
    protected $camper;
    protected $campersFriend;
    protected $friendship;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
        $this->camper = create('App\Camper', ['camp_id' => $this->camp->id]);

        $this->campersFriend = create('App\Camper', ['camp_id' => $this->camp->id]);
        $this->friendship = create('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->camper->id,
            'friend_id' => $this->campersFriend->id
        ]);
    }

//    /** @test */
//    public function a_camp_can_be_updated_by_its_creator()
//    {
//        $this->signIn($this->user);
//
//        $this->patch($this->camp->path(), [
//            'name' => 'Updated Camp.vue Name',
//        ]);
//
//        $this->assertEquals('Updated Camp.vue Name', $this->camp->fresh()->name);
//    }
//
//    /** @test */
//    public function a_camp_may_not_be_updated_by_other_users()
//    {
//        $this->withExceptionHandling();
//
//        $this->signIn();
//
//        $this->patch($this->camp->path(), [
//            'name' => 'Updated Camp.vue Name',
//        ]) ->assertStatus(403);
//    }
//
//    /** @test */
//    public function a_camp_requires_a_name_to_be_updated()
//    {
//        $this->withExceptionHandling();
//
//        $this->signIn($this->user);
//
//        $this->patch($this->camp->path(), [])
//            ->assertSessionHasErrors('name');
//    }

    /** @test */
    public function authorised_users_can_delete_camps()
    {
        $this->signIn($this->user);

        $this->json('DELETE', $this->camp->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('camps', $this->camp->toArray());
        $this->assertDatabaseMissing('campers', $this->camper->toArray());
        $this->assertDatabaseMissing('friendships', $this->friendship->toArray());
    }

    /** @test */
    public function unauthorised_users_may_not_delete_camps()
    {
        $this->withExceptionHandling();

        // Not signed in
        $this->json('DELETE', $this->camp->path())
            ->assertStatus(401);

        // Not the owner
        $this->signIn();

        $this->json('DELETE', $this->camp->path())
            ->assertStatus(403);

        $this->assertDatabaseHas('camps', $this->camp->toArray());
    }

    /** @test */
    public function authorised_users_can_delete_campers()
    {
        $this->signIn($this->user);

        $this->json('DELETE', $this->camper->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('campers', [ 'name' => $this->camper->name ]);
        $this->assertDatabaseMissing('friendships', $this->friendship->toArray());
    }

    /** @test */
    public function deleting_a_camper_also_deletes_all_friendships_camper_is_involved_in()
    {
        $this->signIn($this->user);

        $oppositeFriendship = create('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->campersFriend->id,
            'friend_id' => $this->camper->id,
        ]);

        $this->json('DELETE', $this->camper->path());

        $this->assertDatabaseMissing('friendships', $this->friendship->toArray());
        $this->assertDatabaseMissing('friendships', $oppositeFriendship->toArray());
    }

    /** @test */
    public function unauthorised_users_may_not_delete_campers()
    {
        $this->withExceptionHandling();

        // Not signed in
        $this->json('DELETE', $this->camper->path())
            ->assertStatus(401);

        // Not the owner
        $this->signIn();

        $this->json('DELETE', $this->camper->path())
            ->assertStatus(403);

        $this->assertDatabaseHas('campers', [
            'name' => $this->camper->name
        ]);
    }

}
