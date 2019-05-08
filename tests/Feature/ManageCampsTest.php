<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageCampsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $camp;
    protected $cabin;
    protected $camper;
    protected $campersFriend;
    protected $friendship;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
        $this->cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);
        $this->camper = create('App\Camper', ['camp_id' => $this->camp->id]);

        $this->campersFriend = create('App\Camper', ['camp_id' => $this->camp->id]);
        $this->friendship = create('App\Friendship', [
            'camp_id' => $this->camp->id,
            'camper_id' => $this->camper->id,
            'friend_id' => $this->campersFriend->id
        ]);
    }

    /** @test */
    public function guests_cannot_manage_camps()
    {
        $this->withExceptionHandling();

        $this->get('/camps')->assertRedirect('/login');
        $this->get('/camps/' . $this->camp->id)->assertRedirect('/login');
        $this->get('/camps/create')->assertRedirect('/login');
        $this->post('/camps', [])->assertRedirect('/login');
        $this->patch($this->camp->path(), [])->assertRedirect('/login');
        $this->json('DELETE', $this->camp->path())->assertStatus(401);
    }

    /** @test */
    public function a_user_can_view_all_their_camps()
    {
        $this->signIn($this->user);

        $this->get('/camps')
            ->assertSee(e($this->camp->name));
    }

    /** @test */
    public function users_will_not_see_camps_they_dont_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->get('/camps')
            ->assertDontSee($this->camp->name);
    }

    /** @test */
    public function a_user_can_view_their_camp()
    {
        $this->signIn($this->user);

        $this->get('/camps/' . $this->camp->id)
            ->assertSee(e($this->camp->name));
    }

    /** @test */
    public function users_may_not_view_a_camp_they_dont_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->get('/camps/' . $this->camp->id)
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_visit_the_create_camp_view()
    {
        $this->signIn();

        $this->get('/camps/create')
            ->assertSee('Create a New Camp');
    }

    /** @test */
    public function a_user_can_add_a_new_camp()
    {
        $this->signIn();
        $camp = make('App\Camp', ['user_id' => auth()->id()]);

        $this->post('/camps', $camp->toArray());

        $this->assertDatabaseHas('camps', $camp->toArray());
    }

    /** @test */
    public function a_user_can_delete_their_camp()
    {
        $this->signIn($this->user);

        $this->json('DELETE', $this->camp->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('camps', $this->camp->toArray());
        $this->assertDatabaseMissing('campers', $this->camper->toArray());
        $this->assertDatabaseMissing('cabins', $this->cabin->toArray());
        $this->assertDatabaseMissing('friendships', $this->friendship->toArray());
    }

    /** @test */
    public function users_may_not_delete_camps_they_dont_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->json('DELETE', $this->camp->path())
            ->assertStatus(403);
    }

    /** @test */
    public function users_can_see_campers_that_are_associated_with_their_camp()
    {
        $this->signIn($this->user);

        $camper = create('App\Camper', ['camp_id' => $this->camp->id]);

        $this->get($this->camp->path())
            ->assertSee(e($camper->name));
    }

    /** @test */
    public function users_can_see_cabins_that_are_associated_with_their_camp()
    {
        $this->signIn($this->user);

        $cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);

        $this->get($this->camp->path())
            ->assertSee(e($cabin->name));
    }

    /** @test */
    public function a_camp_can_be_updated_by_its_owner()
    {
        $this->signIn($this->user);

        $this->patch($this->camp->path(), [
            'name' => 'Updated Camp Name',
        ]);

        $this->assertEquals('Updated Camp Name', $this->camp->fresh()->name);
    }

    /** @test */
    public function users_may_not_update_a_camp_they_dont_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->patch($this->camp->path(), [
            'name' => 'Updated Camp Name',
        ]) ->assertStatus(403);
    }

    /** @test */
    public function a_camp_requires_a_name_to_be_updated()
    {
        $this->withExceptionHandling();

        $this->signIn($this->user);

        $this->patch($this->camp->path(), [])
            ->assertSessionHasErrors('name');
    }
}
