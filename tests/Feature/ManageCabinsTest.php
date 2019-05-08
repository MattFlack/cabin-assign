<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageCabinsTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $camp;
    protected $cabin;

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
        $this->cabin = create('App\Cabin', ['camp_id' => $this->camp->id]);
    }

    /** @test */
    public function guests_cannot_manage_cabins()
    {
        $this->withExceptionHandling();

        $this->get($this->camp->path() . '/cabins/create')->assertRedirect('/login');
        $this->post($this->camp->path().'/cabins', [])->assertRedirect('/login');
        $this->json('DELETE', $this->cabin->path())->assertStatus(401);
    }

    /** @test */
    public function users_can_add_a_cabin_to_their_camp()
    {
        $this->signIn($this->user);
        $cabin = make('App\Cabin', ['camp_id' => $this->camp->id]);

        $this->post($this->camp->path().'/cabins', $cabin->toArray());

        $this->assertDatabaseHas('cabins', $cabin->toArray());
    }

    /** @test */
    public function users_may_not_add_a_cabin_to_a_camp_which_is_not_theirs()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->post($this->camp->path().'/cabins', [])
            ->assertStatus(403);
    }

    /** @test */
    public function users_can_view_the_create_cabins_page_of_their_camp()
    {
        $this->signIn($this->user);

        $this->get($this->camp->path() . '/cabins/create')
            ->assertSee('Add Cabins');
    }

    /** @test */
    public function users_cannot_visit_the_create_cabins_view_of_a_camp_which_is_not_theirs()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->get($this->camp->path() . '/cabins/create')
            ->assertStatus(403);
    }

    /** @test */
    public function users_can_delete_cabins_they_own()
    {
        $this->signIn($this->user);

        $this->json('DELETE', $this->cabin->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('cabins', [ 'name' => $this->cabin->name ]);
    }

    /** @test */
    public function users_may_not_delete_cabins_they_dont_own()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->json('DELETE', $this->cabin->path())
            ->assertStatus(403);
    }
}
