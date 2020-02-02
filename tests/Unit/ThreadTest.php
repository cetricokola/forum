<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_a_thread_has_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }
    public function test_a_thread_can_add_a_reply(){
        $this->thread->addReply([
            'body' => 'Foo',
            'user_id' => 1]);
        $this->assertCount(1, $this->thread->replies);
    }
}
