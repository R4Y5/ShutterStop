<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
    return view('admin.edit', compact('user'));
}

        // Customers use account/edit.blade.php
        return view('account.edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'first_name' => 'nullable|string|max:255',
        'last_name'  => 'nullable|string|max:255',
        'contact_no' => 'nullable|string|max:20',
        'address'    => 'nullable|string|max:255',
        'photo'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Only update fields if they were actually filled in
    if ($request->filled('first_name')) {
        $user->first_name = $request->first_name;
    }

    if ($request->filled('last_name')) {
        $user->last_name = $request->last_name;
    }

    if ($request->filled('contact_no')) {
        $user->contact_no = $request->contact_no;
    }

    if ($request->filled('address')) {
        $user->address = $request->address;
    }

    // Handle photo upload
    if ($request->hasFile('photo')) {
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->photo = $request->file('photo')->store('photos', 'public');
    }

    $user->save();

    return redirect()->route('account.edit')
                     ->with('success', 'Your account information has been updated!');
}


    public function changePasswordForm()
    {
        return view('account.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
