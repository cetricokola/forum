<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);
        $thread->addReply([
            'body' => \request('body'),
            'user_id' => Auth::id()]);
        return back()->with('flash', 'Your reply has been left.');
    }

    /**
     * Update an existing reply.
     *
     * @param Reply $reply
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => 'required']);

        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply)
    {

        try {
            $this->authorize('update', $reply);
        } catch (AuthorizationException $e) {
        }


        try {
            $reply->delete();
        } catch (\Exception $e) {
        }
        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        return back();
    }
}
