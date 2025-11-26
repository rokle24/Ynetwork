<?php

namespace App\Http\Controllers;

use App\Models\Friendship;

class FriendshipController extends Controller
{
    public function send($id)
    {
        if (auth()->user()->id == $id) {
            return back()->with('error', 'Cannot friend yourself.');
        }

        $exists = Friendship::where(function($q) use ($id) {
            $q->where('user_id', auth()->id())->where('friend_id', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('user_id', $id)->where('friend_id', auth()->id());
        })->exists();

        if ($exists) {
            return back()->with('error', 'Friend request already exists.');
        }

        Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $id,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Friend request sent.');
    }

    public function accept($id)
    {
        $friendship = Friendship::where('user_id', $id)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $friendship->update(['status' => 'accepted']);

        return back()->with('success', 'Friend request accepted.');
    }

    public function deny($id)
    {
        $friendship = Friendship::where('user_id', $id)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $friendship->delete();

        return back()->with('success', 'Friend request denied.');
    }

    public function remove($id)
    {
        $friendship = Friendship::where(function($q) use ($id) {
            $q->where('user_id', auth()->id())->where('friend_id', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('user_id', $id)->where('friend_id', auth()->id());
        })->firstOrFail();

        $friendship->delete();

        return back()->with('success', 'Friend removed.');
    }
}
