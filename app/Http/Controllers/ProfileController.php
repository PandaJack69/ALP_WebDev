<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfilePicture(Request $request)
{
    // Validate the image input
    $request->validate([
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle the uploaded file
    $image = $request->file('profile_picture');
    $imageName = 'profile_picture_' . time() . '.' . $image->getClientOriginalExtension();

    // Store the image in public/images directory
    $image->move(public_path('images'), $imageName);

    // Update the user's profile_picture path
    $user = Auth::user();
    $user->profile_picture = $imageName;
    $user->save();

    // Return back or redirect with success message
    return back()->with('success', 'Profile picture updated successfully!');
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

    // Handle creating a merchant account
    public function createMerchant(Request $request)
    {
        $request->validate([
            'merchant_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Hash and save the merchant password
        $user->merchant_password = Hash::make($request->merchant_password);
        $user->save();

        // Create a new merchant entry
        DB::table('merchants')->insert([
            'user_id' => $user->id,
            'joined_at' => Carbon::now(),
            'revenue' => 0, // Default value for new merchants
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Merchant account created successfully.');
    }

    // Handle switching roles
    public function switchRoleMerchant(Request $request)
    {
        $request->validate([
            'merchant_password' => 'required',
        ]);

        $user = Auth::user();

        if ($user->current_role === 'user') {
            if (!Hash::check($request->merchant_password, $user->merchant_password)) {
                return redirect()->back()->withErrors(['merchant_password' => 'Incorrect merchant password.']);
            }

            $user->current_role = 'merchant';
            $user->save();

            return redirect()->route('merchant-dashboard')->with('success', 'Switched to Merchant Dashboard.');
        }

        if ($user->current_role === 'merchant') {
            $user->current_role = 'user';
            $user->save();

            return redirect()->route('dashboard')->with('success', 'Switched to User Dashboard.');
        }
        return redirect()->back()->with('error', 'Invalid role switch.');
    }

    public function switchRoleUser(Request $request)
    {
        $user = Auth::user();

        if ($user->current_role === 'merchant') {
            $user->current_role = 'user';
            $user->save();

            // Refresh the session
            Auth::setUser($user);

            return redirect()->route('dashboard')->with('success', 'Switched to User Dashboard.');
        }

        return redirect()->back()->with('error', 'Invalid role switch.');
    }

}
