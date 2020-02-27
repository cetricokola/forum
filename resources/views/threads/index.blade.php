@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="h2">Forum Threads</div>
                <div class="card-body">
                    @foreach( $threads as $thread )
                        <div class="card p-3 mb-3">
                            <article>
                                <div class="level">
                                    <h4 class="flex mb-3">
                                        <a href="{{$thread->path()}}">
                                            @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                                <strong>
                                                    {{ $thread->title }}
                                                </strong>
                                            @else
                                                {{ $thread->title }}
                                            @endif
                                        </a>
                                    </h4>
                                    <a href="{{$thread->path()}}">{{$thread->replies_count}}{{str_plural('reply', $thread->replies_count)}}</a>
                                </div>
                                <div class="body">
                                    {{$thread->body}}
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
