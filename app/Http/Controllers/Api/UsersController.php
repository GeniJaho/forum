<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('name');

        return User::where('name', 'like', "$search%")
            ->select('name')
            ->take(5)
            ->get();
    }
}
