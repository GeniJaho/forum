<?php

namespace App\Http\Controllers;

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
        return $thread->replies()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Channel $channel
     * @param Thread $thread
     * @param Request $request
     * @return Application|ResponseFactory|Reply|Response
     * @throws Exception
     */
    public function store(Channel $channel, Thread $thread, Request $request)
    {
        try {
            $this->validate(request(), [
                'body' => ['required', new SpamFree]
            ]);

            $reply = $thread->addReply([
                'body' => $request->body,
                'user_id' => auth()->id()
            ]);
        } catch (Exception $exception) {
            return response('Your reply could not be saved at the time.', 422);
        }

        return $reply->load('owner');
    }

    /**
     * Display the specified resource.
     *
     * @param Reply $reply
     * @return Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reply $reply
     * @return Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reply $reply
     * @return Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), [
                'body' => ['required', new SpamFree]
            ]);

            $reply->body = $request->body;
            $reply->save();
        } catch (Exception $exception) {
            return response('Your reply could not be saved at the time.', 422);
        }

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
