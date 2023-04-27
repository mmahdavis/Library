<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notification.
     */
    public function index()
    {

        return new NotificationCollection(Notification::orderByDesc('created_at')->get());
    }

    /**
     * Display a listing of the notification filtered by User_id.
     */
    public function filterByUser(Request $request)
    {
        return new NotificationCollection(Notification::where('user_id', $request->user_id)->orderBy('created_at', 'ASC')->orderBy('checked', 'ASC')->get());
    }

    /**
     * Store a newly created notification in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 'user_id' => 'required',
            'type' => 'required',
            'title' => 'required',
            'message' => 'required',
        ]);
        Notification::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Display the specified notification.
     */
    // public function show($id)
    // {
    //     return new NotificationResource(Notification::find($id));
    // }

    /**
     * Update the specified notification in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        // $validatedData = $request->validate([
        //     // 'user_id' => 'required',
        //     'type' => 'required',
        //     'title' => 'required',
        //     'message' => 'required',
        // ]);
        $notification->checked = $request->checked;
        $notification->save();
        return response()->json($notification);
    }

    /**
     * Remove the specified notification from storage.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json('deleted');
    }
}
