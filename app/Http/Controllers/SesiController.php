<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sesi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
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
        return view('sesi.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'event_id' => 'required'
        ], [
            'event_id.required' => 'Event Belum Di pilih.',
        ]);
        $eventId = $request->query('event_id');
        $event = Event::find($eventId);
        return view('sesi.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'speaker' => 'required',
            'room' => 'required',
            'time' => 'required',
            'type' => 'required',
            'grade' => 'required',
            'cv' => 'file|mimes:pdf,jpg,jpeg|max:2048', // Maksimal 2MB
            'materi' => 'file|mimes:pdf,docx,ppt|max:5120', // Maksimal 5MB
        ], [
            'event_id.required' => 'Event ID Kosong.',
            'name.required' => 'Nama Sesi Masih kosong.',
            'speaker.required' => 'Pembicara Masih kosong.',
            'room.required' => 'Nama Ruang Masih kosong.',
            'time.required' => 'Waktu Sesi Masih kosong.',
            'type.required' => 'Jenis Sesi Wajib Di pilih.',
            'grade.required' => 'Penilaian Wajib pilih.',
        ]);

        if ($request->file()) {
            $cvPath = $request->file('cv')->storeAs(
                'uploads/cv', // Folder tujuan
                'cv_' . uniqid() . '.' . $request->file('cv')->getClientOriginalExtension(), // Nama file
                'public' // Disk storage
            );

            $materiPath = $request->file('materi')->storeAs(
                'uploads/materi',
                'materi_' . uniqid() . '.' . $request->file('materi')->getClientOriginalExtension(),
                'public'
            );
            $event = Event::find($request->event_id);
            $sesi = new Sesi();
            $sesi->event_id = $request->event_id;
            $sesi->name = $request->name;
            $sesi->speaker = $request->speaker;
            $sesi->room = $request->room;
            $sesi->time = $request->time;
            $sesi->type = $request->type;
            $sesi->grade = $request->grade;
            $sesi->cv_path = $cvPath;
            $sesi->materi_path = $materiPath;
            $sesi->status = 'inactive';
        } else {
            $event = Event::find($request->event_id);
            $sesi = new Sesi();
            $sesi->event_id = $request->event_id;
            $sesi->name = $request->name;
            $sesi->speaker = $request->speaker;
            $sesi->room = $request->room;
            $sesi->time = $request->time;
            $sesi->type = $request->type;
            $sesi->grade = $request->grade;
            $sesi->status = 'inactive';
        }


        if ($sesi->save()) {
            return redirect()->route('sesi.index')->with('success', 'Data Sesi ' . $event->name . ' Created Successfully.');
        } else {
            return redirect()->route('sesi.index')->with('error', 'Data Sesi ' . $event->name . ' Failed Create.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sesi $sesi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sesi $sesi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sesi $sesi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sesi $sesi)
    {
        if ($sesi->delete()) {
            return redirect()->route('sesi.index')->with('success', 'Sesi Deleted successfully.');
        } else {
            return redirect()->route('sesi.index')->with('error', 'Failed Delete Sesi .');
        }
    }

    public function getSessions(Request $request)
    {
        $eventId = $request->input('event_id');

        if (!$eventId) {
            return response()->json([], 200);
        }

        $sessions = Sesi::where('event_id', $eventId)->get();

        return response()->json($sessions);
    }
}
