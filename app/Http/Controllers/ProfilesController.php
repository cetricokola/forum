<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {

        $activities = $this->getCollection($user);
        return view('profiles.show', [
            'profilesUser' => $user,
            'threads' => $user->threads()->paginate(30),
            'activities' => $activities
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    protected function getCollection(User $user)
    {
        $activities = $user->activity()->latest()->with('subject')->take(50)->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-M-D');
        });
        return $activities;
    }
}

