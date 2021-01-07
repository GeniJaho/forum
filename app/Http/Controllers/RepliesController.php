<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
     * @return RedirectResponse
     */
    public function store(Channel $channel, Thread $thread, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        return back();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return Response
     */
    public function destroy(Reply $reply)
    {
        //
    }
}
