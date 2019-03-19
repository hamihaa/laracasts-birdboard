<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Project has a path method
     *
     * @test 
     * 
     */
    public function it_has_a_path()
    {
        $p = factory('App\Models\Project')->create();

        $this->assertEquals("/projects/$p->id", $p->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $p = factory('App\Models\Project')->create();

        $this->assertInstanceOf('App\Models\User', $p->owner);

    }
}
