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
        $activeEvents = ModelActiveEvent::with(['user', 'event'])->get(); // Ambil data pengguna yang bergabung
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
        $data = new ModelActiveEvent();
        $data->user_id = $request->user_id;
        $data->event_id = $request->event_id;
        $data->isJoin = 1;
        $data->status = $request->status;
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelActiveEvent $modelActiveEvent)
    {
        //
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
}
