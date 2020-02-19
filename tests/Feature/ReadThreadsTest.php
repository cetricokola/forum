<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
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


    public function test_a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function test_a_thread_can_make_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    public function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    public function test_a_user_can_filter_threads_by_any_username()
    {

        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohnDoe = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohnDoe = create('App\Thread');
        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohnDoe->title)
            ->assertDontSee($threadNotByJohnDoe->title);
    }

    public function test_a_user_can_filter_threads_according_to_popularity()
    {
        $threadsWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadsWithTwoReplies], 2);

        $threadsWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadsWithThreeReplies], 3);

        $threadWithNoReply = $this->thread;
        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    function test_a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response);
    }
}
