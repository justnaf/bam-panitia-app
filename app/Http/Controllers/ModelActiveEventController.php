<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ModelActiveEvent;
use App\Models\User;
use Illuminate\Http\Request;

class ModelActiveEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all(); // Ambil semua event
        $activeEvents = ModelActiveEvent::with(['user.roles', 'event'])->get(); // Ambil data pengguna yang bergabung
        return view('events.joined.index', compact(['events', 'activeEvents']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::all();
        $users = User::all();
        return view('events.joined.create', compact(['events', 'users']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cek = ModelActiveEvent::where('user_id', $request->user_id)->where('event_id', $request->event_id)->first();
        if ($cek) {
            return redirect()->route('modelActiveEvents.index')->with('error', 'Invite Gagal Dilakukan User Sudah Join.');
        }
        $data = new ModelActiveEvent();
        $data->user_id = $request->user_id;
        $data->event_id = $request->event_id;
        $data->isJoin = 1;
        $data->status = $request->status;
        $data->number = null;
        $data->save();

        if ($data->wasRecentlyCreated) {
            return redirect()->route('modelActiveEvents.index')->with('success', 'Force Join Sukses Dilakukan.');
        } else {
            return redirect()->route('modelActiveEvents.index')->with('error', 'Force Join Gagal Dilakukan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ModelActiveEvent $modelActiveEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelActiveEvent $modelActiveEvent)
    {
        return view('events.joined.edit', compact('modelActiveEvent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelActiveEvent $modelActiveEvent)
    {
        $modelActiveEvent->number = $request->number;
        if ($modelActiveEvent->save()) {
            return redirect()->route('modelActiveEvents.index')->with('success', 'Berhasil Update Nomor Dada');
        }
        return redirect()->route('modelActiveEvents.index')->with('error', 'Gagal Update Nomor Dada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelActiveEvent $modelActiveEvent)
    {
        if ($modelActiveEvent->delete()) {
            return redirect()->route('modelActiveEvents.index')->with('success', 'Joined Berhasil Dihapus.');
        } else {
            return redirect()->route('modelActiveEvents.index')->with('error', 'Joined Gagal Dihapus.');
        }
    }

    public function fetchUserJoined(Request $request)
    {
        // Get the event ID from the request
        $eventId = $request->input('event_id');

        // Count users by role, specifically for the selected event
        $roleCounts = ModelActiveEvent::where('event_id', $eventId)
            ->with('user.roles') // Make sure to load roles for each user
            ->get()
            ->flatMap(function ($modelActiveEvent) {
                // For each ModelActiveEvent, return the roles of the associated user
                return $modelActiveEvent->user->roles;
            })
            ->groupBy('name') // Group by role name
            ->map(function ($roles) {
                return $roles->count(); // Count the number of users for each role
            });

        // Fetch the event participants
        $modelActiveEvent = ModelActiveEvent::where('event_id', $eventId)
            ->with(['user.dataDiri', 'user.roles', 'event'])
            ->get();

        // Return both the role counts and event data
        return response()->json([
            'roleCounts' => $roleCounts,
            'modelActiveEvent' => $modelActiveEvent,
        ]);
    }
}
