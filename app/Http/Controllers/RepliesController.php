<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Inspections\Spam;
use App\Reply;
use App\Thread;
use Illuminate\Auth\Access\AuthorizationException;
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

    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }

    public function update(Reply $reply)
    {
        try {
            $this->validate(request(), ['body' => 'required|spamfree']);
        } catch (ValidationException $e) {
        }

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
