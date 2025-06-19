<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Hash;

class MerchantProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('merchant-profile.merchant-edit', [
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

        return Redirect::route('merchant-profile.merchant-edit')->with('status', 'profile-updated');
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
    // public function createMerchant(Request $request)
    // {
    //     $request->validate([
    //         'merchant_password' => 'required|min:8|confirmed',
    //     ]);

    //     $user = Auth::user();
    //     $user->merchant_password = Hash::make($request->merchant_password);
    //     $user->save();

    //     return redirect()->back()->with('success', 'Merchant account created successfully.');
    // }

    // // Handle switching roles
    // public function switchRoleMerchant(Request $request)
    // {
    //     $request->validate([
    //         'merchant_password' => 'required',
    //     ]);

    //     $user = Auth::user();

    //     if ($user->current_role === 'user') {
    //         if (!Hash::check($request->merchant_password, $user->merchant_password)) {
    //             return redirect()->back()->withErrors(['merchant_password' => 'Incorrect merchant password.']);
    //         }

    //         $user->current_role = 'merchant';
    //         $user->save();

    //         return redirect()->route('merchant-dashboard')->with('success', 'Switched to Merchant Dashboard.');
    //     }

    //     if ($user->current_role === 'merchant') {
    //         $user->current_role = 'user';
    //         $user->save();

    //         return redirect()->route('dashboard')->with('success', 'Switched to User Dashboard.');
    //     }
    //     return redirect()->back()->with('error', 'Invalid role switch.');
    // }

    public function updateMerchantPassword(Request $request)
    {
        $request->validate([
            'current_merchant_password' => ['required', 'current_password'], // Validate the current password
            'new_merchant_password' => ['required', 'string', 'min:8', 'confirmed'], // Validate new password and confirm
        ]);

        $user = Auth::user();
        $user->merchant_password = Hash::make($request->new_merchant_password);
        $user->save();

        return redirect()->route('merchant-profile.merchant-edit')->with('status', 'merchant-password-updated');
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
