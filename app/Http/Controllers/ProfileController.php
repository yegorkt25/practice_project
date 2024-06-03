<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function follow(int $followedUserId): RedirectResponse
    {
        $following = DB::table('user_followers')->select('user_id')->where('follower_id', request()->user()->id)->get();
//        Log::debug("FOLLOW");
        $followingIds = [];

        foreach ($following as $follower) {
            $followingIds[] = $follower->user_id;
        }


        if (!in_array($followedUserId, $followingIds)) {
            DB::table('user_followers')->insert([
                'user_id' => $followedUserId,
                'follower_id' => request()->user()->id,
            ]);
            return Redirect::back();
        }
        return Redirect::back();
    }

    public function unfollow(int $followedUserId): RedirectResponse
    {
        $following = DB::table('user_followers')->select('user_id')->where('follower_id', request()->user()->id)->get();
        $followingIds = [];

        foreach ($following as $follower) {
            $followingIds[] = $follower->user_id;
        }
//        Log::debug($followingIds);


        if (in_array($followedUserId, $followingIds)) {
            Log::debug('ASDASDASD');
            DB::table('user_followers')->where('follower_id', request()->user()->id)->where('user_id', $followedUserId)->delete();
            return Redirect::back();
        }
        return Redirect::back();
    }

    public function show(User $user): View {

        $posts = Post::query()->
        where('user_id', $user->id)->
        orderBy('created_at', 'desc')->
        get();
        $followers = DB::table('user_followers')->select('user_id')->where('follower_id', request()->user()->id)->get();
        $following = DB::table('user_followers')->select('follower_id')->where('user_id', request()->user()->id)->get();

        $followersIds = [];

        foreach ($followers as $follower) {
            $followersIds[] = $follower->user_id;
        }

        if (auth()->id() != $user->id) {
            Log::debug(print_r($followersIds, true));

            if (in_array($user->id, $followersIds)) {
                return view('profile.show', ['user' => $user, 'posts' => $posts, 'is_followed' => true, 'followers' => $followers, 'following' => $following]);
            }
        }
        return view('profile.show', ['user' => $user, 'posts' => $posts, 'is_followed' => false, 'followers' => $followers, 'following' => $following]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if (User::query()->where('name', $request->user()->name)->exists()) {
            return Redirect::route('profile.edit')->with('status', 'profile-not-updated');
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        $posts = Post::query()->
                        where('user_id', $user->id)->
                        orderBy('created_at', 'desc')->
                        get();

        foreach ($posts as $post) {
            $post->delete();
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
