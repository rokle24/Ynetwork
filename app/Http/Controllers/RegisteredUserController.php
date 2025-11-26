<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\Post;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }


    public function store()
    {

        if (
            !$attributes = request()->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => ['required', 'email', 'unique:users', 'confirmed'],
                'password' => ['required', 'confirmed', Password::min(8)],
                'birthdate' => [
                    'required',
                    'date',
                    'before_or_equal:' . Carbon::now()->subYears(18)->toDateString(),
                ],
            ])
        ) {
            throw ValidationException::withMessages([
            ]);
        }
        ;

        $user = User::create($attributes);

        Auth::login($user);

        return redirect('/for-you');
    }

    //User search function for the search bar (Profile_picture is commented out for now as it is not something within the database and we wanted to do it differently)
    public function search(Request $request)
    {
        $query = $request->get('query');

        $users = User::whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"])
            ->select('id', 'first_name', 'last_name'/*, 'profile_picture'*/)
            ->get();

        return response()->json($users);
    }

    //Function to show the searched user's profile page
    public function show($id)
    {
        $profiledata = User::findOrFail($id);

        $posts = Post::with('user')
            ->where('user_id', $profiledata->id)
            ->latest()
            ->get();


        return view('user.profile', compact('profiledata', 'posts'));
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->is_admin || auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to delete this user.');
        }

        $user->delete();

        return redirect()->route('user.for-you')->with('message', 'User deleted successfully.');
    }

}
