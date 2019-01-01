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

    public function setUp()
    {
        parent::setUp();

        $this->user = create('App\User');
        $this->camp = create('App\Camp', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function a_camp_can_be_updated_by_its_creator()
    {
        $this->signIn($this->user);

        $this->patch($this->camp->path(), [
            'name' => 'Updated Camp.vue Name',
        ]);

        $this->assertEquals('Updated Camp.vue Name', $this->camp->fresh()->name);
    }

    /** @test */
    public function a_camp_may_not_be_updated_by_other_users()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $this->patch($this->camp->path(), [
            'name' => 'Updated Camp.vue Name',
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
