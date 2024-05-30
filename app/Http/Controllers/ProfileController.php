<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function index(Request $request): View
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function show(User $user): View {
        if ($user->id == Auth::id()) {
            return view('profile.index', ['user' => Auth::user()]);
//            return to_route('profile.index', ['user' => Auth::user()]);
        }
        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
//        Log::debug($request->user());      : View
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
//        return 'hui';
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
