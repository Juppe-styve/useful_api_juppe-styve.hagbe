<?php

namespace App\Http\Controllers;

use App\Models\SessionTime;
use Illuminate\Http\Request;

class SessionTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "task_name" => "required|string",
            "start_time" => "required|after_or_equal:today"
        ]);
        //vérifier s'il n'y a pas une autre session à cette date
        $session = SessionTime::where(["user_id" => auth()->id(), "start_time" => $request->start_time])->count();
        if ($session > 0) {
            return response([
                "error" => "une session existe à cette date",
            ], 403);
        }
        $session_add = SessionTime::create([
            "task_name" => $request->task_name,
            "start_time" => $request->start_time,
            "user_id" => auth()->id()
        ]);
        return response([
            "session_id" => $session_add->id,
            "user_id" => $session_add->user_id,
            "task_name" => $session_add->task_name,
            "start_time" => $session_add->start_time
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionTime $sessionTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionTime $sessionTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionTime $sessionTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionTime $sessionTime)
    {
        //
    }
}