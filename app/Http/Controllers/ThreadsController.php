<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\Trending;
use App\Rules\SpamFree;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @param Trending $trending
     * @return Application|Factory|View|Response
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param SpamFree $spamFree
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request, SpamFree $spamFree)
    {
        $request->validate([
            'title' => ['required', $spamFree],
            'body' => ['required', $spamFree],
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => $request->channel_id,
            'title' => $request->title,
            'body' => $request->body
        ]);

        if ($request->wantsJson()) {
            return $thread;
        }

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param Channel $channel
     * @param Thread $thread
     * @return Application|Factory|View
     * @throws Exception
     */
    public function show(Channel $channel, Thread $thread, Trending $trending)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        return view('threads.show', [
            'thread' => $thread,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Channel $channel
     * @param Thread $thread
     * @param Request $request
     * @param SpamFree $spamFree
     * @return Thread
     * @throws AuthorizationException
     */
    public function update(Channel $channel, Thread $thread, Request $request, SpamFree $spamFree)
    {
        $this->authorize('update', $thread);

        $thread->update($request->validate([
            'title' => ['required', $spamFree],
            'body' => ['required', $spamFree]
        ]));

        return $thread;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel $channel
     * @param Thread $thread
     * @return Response
     * @throws Exception
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        return response([], 204);
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(20);
    }
}
