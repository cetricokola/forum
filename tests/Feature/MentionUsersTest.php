<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    function test_mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);
        $jane = create('App\User', ['name' => 'JaneDoe']);
        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Hey @JaneDoe check this out.'
        ]);
        $this->json('post', $thread->path() . '/replies', $reply->toArray());
        $this->assertCount(1, $jane->notifications);
    }
    function test_it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['name' => 'cetric']);
        create('App\User', ['name' => 'cetric2']);
        create('App\User', ['name' => 'happy']);

        $results = $this->json('GET', '/api/users', ['name' => 'cetric']);

        $this->assertCount(2, $results->json());
    }
}
