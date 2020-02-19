<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordActivity;
    protected $fillable = [
        'user_id', 'thread_id', 'body',
    ];
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    protected $appends = ['favoritesCount', 'isFavorited'];

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        if (!$this->favorites()->where(['user_id' => auth()->id()])->exists()) {

            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

    public function thread()
    {
        return $this->belongsTo('App\Thread');
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
}
