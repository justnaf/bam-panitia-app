<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ModelRequestEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::where('user_id', Auth::id())->get();
        }
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $event = new Event();
        $event->user_id = Auth::id();
        $event->name = $request->name;
        $event->location = $request->location;
        $event->location_url = $request->location_url;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->institution = $request->institution;
        $event->pic = $request->pic;
        $event->email = $request->email;
        $event->max_person = $request->max_person;

        if ($event->save()) {
            return redirect()->route('events.index')->with('success', 'Draft Kegiatan Created Successfully.');
        } else {
            return redirect()->route('events.index')->with('error', 'Draft Kegiatan Created Failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('sesi');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        if ($event->status == 'draft') {
            $event->user_id = $event->user_id;
            $event->name = $request->name;
            $event->location = $request->location;
            $event->location_url = $request->location_url;
            $event->start_date = $request->start_date;
            $event->end_date = $request->end_date;
            $event->institution = $request->institution;
            $event->max_person = $request->max_person;
            $event->pic = $request->pic;
            $event->email = $request->email;
            $event->status = $event->status;
            if ($event->save()) {

                return redirect()->route('events.index')->with('success', 'Draft Kegiatan Updated Successfully.');
            } else {
                return redirect()->route('events.index')->with('error', 'Draft Kegiatan Updated Failed.');
            }
        } elseif ($event->status == 'submission') {
            return redirect()->route('events.index')->with('warning', 'Proses Pengajuan Data Tidak Dapat Di Edit.');
        } else {
            $event->user_id = $event->user_id;
            $event->name = $event->name;
            $event->location = $event->location;
            $event->location_url = $event->location_url;
            $event->start_date = $event->start_date;
            $event->end_date = $event->end_date;
            $event->institution = $event->institution;
            $event->max_person = $event->max_person;
            $event->pic = $event->pic;
            $event->email = $event->email;
            $event->status = $request->status;
            if ($event->save()) {

                return redirect()->route('events.index')->with('success', 'Kegiatan Updated Successfully.');
            } else {
                return redirect()->route('events.index')->with('error', 'Kegiatan Updated Failed.');
            }
        }
        return redirect()->route('events.index')->with('error', 'Ada Sesuatu Yang Salah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if ($event->delete()) {
            return redirect()->route('events.index')->with('success', 'Event Deleted successfully.');
        } else {
            return redirect()->route('events.index')->with('error', 'Failed Delete Event .');
        }
    }

    public function storeSubmission(Event $event)
    {
        $submission = new ModelRequestEvent();
        $submission->user_id = $event->user_id;
        $submission->event_id = $event->id;
        $submission->event_name = $event->name;
        $submission->status = 'pending';
        if ($submission->save()) {
            $event->status = 'submission';
            if ($event->save()) {
                return redirect()->route('events.index')->with('success', 'Pengajuan Berhasil Dibuat.');
            } else {
                return redirect()->route('events.index')->with('warning', 'Gagal Update Status Event.');
            }
        } else {
            return redirect()->route('events.index')->with('error', 'Failed Untuk Buat Pengajuan Kegiatan.');
        }
    }
}
