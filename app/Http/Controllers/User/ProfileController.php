<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function uploadProfilePicture(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Delete old profile photo if it exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store new photo
        $path = $request->file('image')->store('profile-photos', 'public');

        $user->profile_photo_path = $path;
        $user->save();

        return redirect()->back()->with('success', 'Profile picture updated successfully!');
    }

    /**
     * Delete profile picture.
     */
    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->profile_photo_path = null;
        $user->save();

        return redirect()->back()->with('success', 'Profile picture removed successfully!');
    }


    public function changeProfilePicture(Request $request)
    {
        $user = Auth::user();


        return view('user.update-picture', [
            'user' => $user
        ]);
    }
}
