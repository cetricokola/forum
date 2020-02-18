@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> {{$profilesUser->name}}</div>
                    <div class="card-body">
                        <small>Since {{$profilesUser->created_at->diffForHumans()}}</small>
                        @foreach($activities as $date => $activity)
                            <h3 class="page-header">{{$date}}</h3>
                            @foreach($activity as $record)
                                <div class="level">
                                    <span class="flex">
                                        @if (view()->exists("profiles.activities.{$record->type}"))
                                            @include ("profiles.activities.{$record->type}", ['activity' => $record])
                                        @endif
                                        </span>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
