@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> {{$profilesUser->name}}</div>

                    <div class="card-body">
                        <small>Since {{$profilesUser->created_at->diffForHumans()}}</small>
                        @foreach($threads as $thread)
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <a href="#">{{$thread->creator->name}}</a> posted:
                                        {{$thread->title}}</div>
                                    <div class="card-body">
                                        <div class="body">
                                            {{$thread->body}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                {{$threads->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
