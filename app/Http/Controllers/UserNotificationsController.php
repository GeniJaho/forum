<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;

class UserNotificationsController extends Controller
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
        return auth()->user()->unreadNotifications;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param $notificationId
     * @return void
     */
    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->find($notificationId)->markAsRead();
    }
}
