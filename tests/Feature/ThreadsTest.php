<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    private $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();

    }

    public function test_a_user_can_browse_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_threads()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_associated_to_a_thread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);

    }
}
