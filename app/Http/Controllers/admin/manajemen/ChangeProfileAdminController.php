<?php

namespace App\Http\Controllers\admin\manajemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ChangeProfileAdminController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('layouts.main', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password' => 'nullable|min:8',
            'img_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('img_profile')) {
            if ($user->img_profile) {
                Storage::delete('public/' . $user->img_profile);
            }
            $filePath = $request->file('img_profile')->store('profiles', 'public');
            $user->img_profile = $filePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
