<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];
    protected $fillable = [
        'type',
        'user_id',
        'subject_id',
        'subject_type'];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed($user)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take(50)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}

