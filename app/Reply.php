<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'user_id', 'thread_id', 'body',
    ];
    public function owner(){
        return $this->belongsTo('App\User', 'user_id');
    }
    public function favorites(){
        return $this->morphMany(Favorite::class, 'favorited');
    }
    public function favorite(){
        if (!$this->favorites()->where(['user_id' => auth()->id()])->exists()){

      $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }
}
