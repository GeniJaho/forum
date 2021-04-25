<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\ThreadSubscription;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, Request $request)
    {
        $thread->subscribe();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThreadSubscription  $threadSubscription
     * @return \Illuminate\Http\Response
     */
    public function show(ThreadSubscription $threadSubscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ThreadSubscription  $threadSubscription
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreadSubscription $threadSubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThreadSubscription  $threadSubscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ThreadSubscription $threadSubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
