<div class="card">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
            <a href="#">{{$reply->owner->name}}</a> said {{$reply->created_at->diffForHumans()}}
            </h5>

                <form method="POST" action="/replies/{{$reply->id}}/favorites" {{$reply->isFavorited() ? 'disabled': ''}}>
                    {{csrf_field() }}
                    <button type="submit" class="btn btn-success">{{$reply->favorites_count()}}{{str_plural('Favorite', $reply->favorites_count())}}</button>
                </form>
        </div>
        <div class="card-body">
            <div class="body">
                {{$reply->body}}
            </div>
        </div>
    </div>
</div>
