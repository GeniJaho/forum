<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserAvatarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image']
        ]);

        $avatarPath = $request->file('avatar')->store('avatars', 'public');

        auth()->user()->update([
            'avatar_path' => $avatarPath
        ]);

        return back();
    }
}
