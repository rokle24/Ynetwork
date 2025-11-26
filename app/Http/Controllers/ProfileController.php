<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    /**
     * Display posts for "Profile" page.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {

        if (!auth()->check()) {
        return redirect('/'); // redirect guests to homepage
    }

        $profiledata = auth()->user();

        $posts = Post::with('user')
            ->where('user_id', $profiledata->id)
            ->latest()
            ->get();

        return view('user.profile', compact('posts', 'profiledata'));
    }

    public function editUser(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'bio' => ['nullable', 'string'],
        ]);

        $user->email = $validated['email'];
        $user->bio   = $validated['bio'];

        $user->save();

        return redirect('/profile');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'picture' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = auth()->user();

        if ($user->profile_picture && $user->profile_picture !== 'profilePictures/default.jpg') {
            $oldPath = public_path($user->profile_picture);

            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $filename = $user->id . '.' . $request->picture->extension();
        $path = 'profilePictures/' . $filename;

        $request->picture->move(public_path('profilePictures'), $filename);

        $user->profile_picture = $path;
        $user->save();

        return back()->with('success', 'Profile picture updated.');
    }

}
