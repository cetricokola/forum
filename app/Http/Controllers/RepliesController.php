<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Thread;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RepliesController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store($channelId, Thread $thread)
    {
        $this->validateReply();
        $reply = $thread->addReply([
            'body' => \request('body'),
            'user_id' => Auth::id()]);
        if (request()->expectsJson()) {
            return $reply->load('owner');
        }
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

        $this->validateReply();

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

    protected function validateReply()
    {
        try {
            $this->validate(request(), ['body' => 'required']);
        } catch (ValidationException $e) {
        }

        resolve(Spam::class)->detect(request('body'));
    }
}
