<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCampsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $camp;
    protected $camper;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
        $this->camper = create('App\Camper', ['camp_id' => $this->camp->id]);
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
    public function a_user_can_delete_their_camp()
    {
        $this->signIn($this->user);

        $anotherCamper = create('App\Camper', ['camp_id' => $this->camp->id]);
        $friendship = create('App\Friendship',
            [
                'camper_id' => $this->camper->id,
                'friend_id' => $anotherCamper->id
            ]);

        $this->json('DELETE', $this->camp->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('camps', $this->camp->toArray());
        $this->assertDatabaseMissing('campers', $this->camper->toArray());
        $this->assertDatabaseMissing('friendships', $friendship->toArray());
    }

    /** @test */
    public function unauthenticated_users_may_not_delete_camps()
    {
        $this->withExceptionHandling();

        $this->json('DELETE', $this->camp->path())
            ->assertStatus(401);
    }

    /** @test */
    public function camps_may_only_be_deleted_by_those_with_permission()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->json('DELETE', $this->camp->path())
            ->assertStatus(403);

        $this->assertDatabaseHas('camps', $this->camp->toArray());
    }
}
