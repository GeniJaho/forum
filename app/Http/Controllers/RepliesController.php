<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Rules\SpamFree;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return LengthAwarePaginator
     */
    public function index(Channel $channel, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Channel $channel
     * @param Thread $thread
     * @param CreatePostRequest $request
     * @return Reply|Application|ResponseFactory|Response
     */
    public function store(Channel $channel, Thread $thread, CreatePostRequest $request)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        return $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id()
        ])->load('owner');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reply $reply
     * @return Reply
     * @throws AuthorizationException
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $request->validate([
            'body' => ['required', new SpamFree]
        ]);

        $reply->update([
            'body' => $request->body
        ]);

        return $reply;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return RedirectResponse|Response
     * @throws AuthorizationException
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        if (request()->wantsJson()) {
            return response(['status' => 'Your reply was deleted!']);
        }

        return back()->with('flash', 'Your reply was deleted!');
    }
}
