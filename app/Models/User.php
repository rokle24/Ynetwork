<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date',
            'is_admin' => 'boolean',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

//    public function getProfilePictureAttribute()
//    {
//        $id = $this->id;
//
//        $png = public_path("profilePictures/{$id}.png");
//        $jpg = public_path("profilePictures/{$id}.jpg");
//
//        if (File::exists($png)) {
//            return "/profilePictures/{$id}.png";
//        }
//
//        if (File::exists($jpg)) {
//            return "/profilePictures/{$id}.jpg";
//        }
//
//        return "/profilePictures/default.jpg";
//    }

    // friendships I sent
    public function sentRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id');
    }

    // friendships I received
    public function receivedRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id');
    }

    // check if friends
    public function isFriendWith(User $user)
    {
        return Friendship::where(function($q) use ($user) {
            $q->where('user_id', $this->id)
              ->where('friend_id', $user->id)
              ->where('status', 'accepted');
        })->orWhere(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('friend_id', $this->id)
              ->where('status', 'accepted');
        })->exists();
    }

    public function friends()
    {
        return User::whereIn('id', function ($query) {
            $query->select('friend_id')
                ->from('friendships')
                ->where('user_id', $this->id)
                ->where('status', 'accepted')
            ->union(
                \DB::table('friendships')
                ->select('user_id')
                ->where('friend_id', $this->id)
                ->where('status', 'accepted')
            );
        })->get();
    }


    // get pending request with user
    public function friendshipWith(User $user)
    {
        return Friendship::where(function($q) use ($user) {
            $q->where('user_id', $this->id)
              ->where('friend_id', $user->id);
        })->orWhere(function($q) use ($user) {
            $q->where('user_id', $user->id)
              ->where('friend_id', $this->id);
        })->first();
    }

}
