<?php

namespace App;

use Carbon\Carbon;
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

    /**
     * Boot the reply instance.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

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

    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/\@([^\s\.]+)/', $this->body, $matches);

        return $matches[1];
    }
}
