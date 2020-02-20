<?php

namespace Tests\Unit;

use App\Reply;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_reply_has_owner()
    {
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User', $reply->owner);
    }
    function test_it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }
    function test_it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = new Reply([
            'body' => '@Cetric wants to talk to @Cetric'
        ]);

        $this->assertEquals(['Cetric', 'Cetric'], $reply->mentionedUsers());
    }
    function test_it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new Reply([
            'body' => 'Hello @Cetric.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/Cetric">@Cetric</a>.',
            $reply->body
        );

    }
}
