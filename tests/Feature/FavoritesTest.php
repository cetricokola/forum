<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    public function test_an_authenticated_user_can_favorite_a_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('/replies/' . $reply->id . './favorites');
        $this->assertCount(1, $reply->favorites);
    }

    public function test_a_guest_user_can_favorite_a_reply()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    public function test_an_authenticated_user_can_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        try {

            $this->post('/replies/' . $reply->id . './favorites');
            $this->post('/replies/' . $reply->id . './favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert two records');
        }
        $this->assertCount(1, $reply->favorites);
    }

}
