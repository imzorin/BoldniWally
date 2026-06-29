<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile dashboard.
     */
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        return view('profile.dashboard', [
            'user' => $user,
            'favoritesCount' => $user->favorites()->count(),
            'reviewsCount' => $user->reviews()->count(),
            'watchlistCount' => $user->watchlists()->count(),
            'watchlistBreakdown' => [
                'plan_to_watch' => $user->watchlists()->where('status', 'plan_to_watch')->count(),
                'watching' => $user->watchlists()->where('status', 'watching')->count(),
                'completed' => $user->watchlists()->where('status', 'completed')->count(),
                'dropped' => $user->watchlists()->where('status', 'dropped')->count(),
            ],
            'recentReviews' => $user->reviews()->latest()->take(5)->get(),
            'recentFavorites' => $user->favorites()->latest()->take(6)->get(),
            'recentWatchlist' => $user->watchlists()->latest()->take(6)->get(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
