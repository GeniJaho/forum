<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Support\Facades\Cache;

class ChannelsController extends Controller
{
    public function index()
    {
        return Cache::rememberForever('channels', function () {
            return Channel::all();
        });
    }
}
