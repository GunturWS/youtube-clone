<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Update basic info
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update password if provided
        if ($request->filled('current_password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new_password)
                ]);
            } else {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    // Delete account
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ]);

        $user = Auth::user();
        
        // Logout user
        Auth::logout();
        
        // Delete user
        $user->delete();
        
        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

    // ProfileController
public function dashboard()
{
    $stats = [
        'liked_videos' => auth()->user()->likes()->count(),
        'subscriptions' => auth()->user()->subscriptions()->count(),
        'playlists' => auth()->user()->playlists()->count(),
    ];
    
    return view('profile.dashboard', compact('stats'));
}

    public function myComments()
    {
     $comments = auth()->user()
            ->comments()
            ->with(['replies'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
    return view('profile.comments', compact('comments'));
    }
    public function subscriptions()
{
    $subscriptions = auth()->user()
        ->subscriptions()
        ->orderBy('created_at', 'desc')
        ->paginate(12);
    
    return view('profile.subscriptions', compact('subscriptions'));
}
}