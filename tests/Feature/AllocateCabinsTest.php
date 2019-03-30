<?php

namespace Tests\Feature;

use App\Camper;
use App\AllocatedBed;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AllocateCabinsTest extends TestCase
{
    use DatabaseMigrations;

    protected $user;
    protected $camp;

    public function setUp()
    {
        parent::setUp();
        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function authorised_users_can_allocate_cabins_to_all_campers_in_a_camp()
    {
        $this->signIn($this->user);

        $friendships = $this->createFriendships(12, $this->camp->id);
        create('App\Cabin', ['camp_id' => $this->camp->id, 'number_of_beds' => 6], 2);

        $this->post($this->camp->path() . '/allocate-beds');

        foreach($friendships as $friendship) {
            $this->assertTrue($friendship->camper->hasCabin());
            $this->assertTrue($friendship->friendOfCamper->hasCabin());
            $this->assertEquals(
                $friendship->camper->cabin_id,
                $friendship->friendOfCamper->cabin_id);
        }
    }

    /** @test */
    public function campers_without_friends_are_allocated_to_cabins()
    {
        $this->signIn($this->user);

        $campers = create('App\Camper', ['camp_id' => $this->camp->id], 3);
        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id, 'number_of_beds' => 4]);

        $this->post($this->camp->path() . '/allocate-beds');

        $campers = $campers->fresh();
        foreach($campers as $camper) {
            $this->assertEquals($cabin->id, $camper->cabin_id);
        }
    }

    /** @test */
    public function unauthorised_users_may_not_allocate_cabins()
    {
        $this->withExceptionHandling();

        // Not signed in
        $this->post($this->camp->path() . '/allocate-beds')
            ->assertStatus(403);

        // Not the owner
        $this->signIn();

        $this->post($this->camp->path() . '/allocate-beds')
            ->assertStatus(403);
    }

    /** @test */
    public function authorised_users_can_deallocate_all_cabins()
    {
        $this->signIn($this->user);

        $campers = create('App\Camper', ['camp_id' => $this->camp->id],2);
        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id, 'number_of_beds' => 6]);

        $this->post($this->camp->path() . '/allocate-beds');

        $campers = $campers->fresh();
        foreach ($campers as $camper) {
            $this->assertEquals($cabin->id, $camper->cabin_id);
        }

        $this->delete($this->camp->path() . '/allocate-beds');

        $campers = $campers->fresh();
        foreach ($campers as $camper) {
            $this->assertNull($camper->cabin_id);
        }
    }

    /** @test */
    public function unauthorised_users_may_not_deallocate_cabins()
    {
        $this->withExceptionHandling();

        // Not signed in
        $this->delete($this->camp->path() . '/allocate-beds')
            ->assertStatus(403);

        // Not the owner
        $this->signIn();

        $this->delete($this->camp->path() . '/allocate-beds')
            ->assertStatus(403);
    }


    // Must be even number of friendships, minimum of 2
    // Each friendship will have a reciprocal friendship.
    protected function createFriendships($numFriendships, $campId)
    {
        $friendships = [];
        for($i = 0; $i < ($numFriendships / 2); $i++) {
            $campers = create('App\Camper', ['camp_id' => $campId], 2);

            $friendships[] = create('App\Friendship', [
                'camp_id' => $campId,
                'camper_id' => $campers[0]->id,
                'friend_id' => $campers[1]->id,
            ]);

            $friendships[] = create('App\Friendship', [
                'camp_id' => $campId,
                'camper_id' => $campers[1]->id,
                'friend_id' => $campers[0]->id,
            ]);
        }
        return $friendships;
    }
}
