<?php

namespace App\Http\Controllers;

use App\Models\Reply;

class BestRepliesController extends Controller
{
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);

        $reply->thread->markBestReply($reply);
    }
}
