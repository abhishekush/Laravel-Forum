<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ReadThreadsTest extends TestCase
{
    /**
      @test
     */

    protected $thread;

    use DatabaseMigrations;

    public function setUp(){
        parent::setUp();
        $this->thread = factory('App\Thread')->create();

    }

    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }

    /** @test */

    public function a_user_can_read_single_thread(){
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/'.$this->thread->id);
        $response->assertSee($this->thread->title);
    }

    /** @test */

    public function a_user_can_see_replies_associated_with_a_thread(){
        $reply = factory('App\Reply')
                       ->create(['thread_id'=>$this->thread->id]);
        $response = $this->get('/threads/'. $this->thread->id);
        $response->assertSee($reply->body);
    }
}
