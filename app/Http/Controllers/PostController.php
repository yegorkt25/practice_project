<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $following = DB::table('user_followers')->select('user_id')->where('follower_id', request()->user()->id)->get();

        $following_ids = [];

        foreach ($following as $follow) {
            $following_ids[] = $follow->user_id;
        }

        $following_ids[] = request()->user()->id;

        $posts = Post::query()->whereIn('user_id', $following_ids)->orderBy('created_at', 'desc')->get();

        return view('post.index', compact('posts'));
    }

    public function like(Post $post): RedirectResponse {
        $likes = DB::table('posts_likes')->select('user_id')->where('post_id', $post->id)->get();

        $ids = [];

        foreach ($likes as $like) {
            $ids[] = $like->user_id;
        }

        if (!in_array(request()->user()->id, $ids)) {
            DB::table('posts_likes')->insert([
                'post_id' => $post->id,
                'user_id' => request()->user()->id,
            ]);
        }
        return to_route('post.show', compact('post'));
    }

    public function unlike(Post $post): RedirectResponse {
        $likes = DB::table('posts_likes')->select('user_id')->where('post_id', $post->id)->get();

        $ids = [];

        foreach ($likes as $like) {
            $ids[] = $like->user_id;
        }

        if (in_array(auth()->id(), $ids)) {
            DB::table('posts_likes')->where('post_id', $post->id)->where('user_id', auth()->id())->delete();
        }

        return to_route('post.show', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|max:255',
            'text' => 'required|max:255',
        ]);

        $data['user_id'] = $request->user()->id;

        $post = Post::create($data);

        return to_route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $likes = DB::table('posts_likes')->select('user_id')->where('post_id', $post->id)->get();

        $ids = [];

        foreach ($likes as $like) {
            $ids[] = $like->user_id;
        }

        if (!in_array(auth()->id(), $ids)) {
            return view('post.show', ['post' => $post, 'likes' => $likes, 'liked' => false]);
        }

        return view('post.show', ['post' => $post, 'likes' => $likes, 'liked' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'text' => 'required|max:255',
        ]);

        $post->update($data);


        return to_route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index');
    }
}
