<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class ManageProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_create_projects()
    {
        $attributes = factory('App\Models\Project')->raw();
        // after post, expect validation errors
        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_single_project()
    {
        $p = factory('App\Models\Project')->create();
        // after post, expect validation errors
        $this->get($p->path())->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_create_project_page()
    {
        $this->get('/projects/create')->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->actingAs(factory('App\Models\User')->create());

        // $this->withoutExceptionHandling();
        
        // $this->get('/projects/create')->assertStatus(200);
        // https://laravel.com/docs/5.7/http-tests#available-assertions
        $this->get('/projects/create')->assertOk();

        $attributes = [
            'title' => $this->faker->sentence,
            'description'   => $this->faker->paragraph
        ];

        // after post, expect redirect
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        //check that db has data
        $this->assertDatabaseHas('projects', $attributes);
        // on get to index, see title
        $this->get('/projects')->assertSee($attributes['title']);
    }
    
    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->be(factory('App\Models\User')->create());
        $this->withoutExceptionHandling();

        $p = factory('App\Models\Project')->create(['owner_id'  => auth()->id()]);

        $this->get($p->path())
        ->assertSee($p->title)
        ->assertSee($p->description);

    }

    /** @test */
    public function a_authenticated_user_can_not_view_a_project_of_others()
    {
        $this->be(factory('App\Models\User')->create());

        $p = factory('App\Models\Project')->create();

        $this->get($p->path())->assertStatus(403);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\Models\User')->create());

        // make, create, or raw (make doesnt store to db, create stores, raw creates an array)
        $attributes = factory('App\Models\Project')->raw(['title' => '']);

        // after post, expect validation errors
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\Models\User')->create());

        $attributes = factory('App\Models\Project')->raw(['description' => '']);

        // after post, expect validation errors
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }



}
