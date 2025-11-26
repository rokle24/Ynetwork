<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    
    /**
     * Display posts for "For You" page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function foryou()
    {
        $posts = Post::all()->sortByDesc('updated_at');
        return view('user.for-you', compact('posts'));
    }

    
    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        ]);

        Post::create([
            'user_id' => Auth::id(), 
            'title' => $validated['title'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('user.profile')
        ->with('success','Post created successfully.');
    }
    

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        $post = Post::find($id);
        $post->update($request->all());
        return redirect()->route('user.profile')
        ->with('success','Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $user = auth()->user();
        if (!$user->is_admin && $post->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $post->delete();
        return redirect()->route('user.profile')
        ->with('success','Post deleted successfully.');
    }
    // routes functions
    /**
     * Show the form for creating a new post.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }
    /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }
    /**
     * Show the form for editing the specified post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('user.edit-post', compact('post'));
    }
    }
