<?php

namespace App\Http\Controllers;

use App\Thread;
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
}
