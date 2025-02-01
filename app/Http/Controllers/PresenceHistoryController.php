<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PresenceHistory;
use Illuminate\Http\Request;
use App\Models\ModelActiveEvent;
use App\Models\Sesi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PresenceHistoryController extends Controller
{
    public function listView()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->get();
        }

        return view('presences.list.index', compact('events'));
    }

    public function presencesIndex()
    {
        $activeEvents = ModelActiveEvent::where('user_id', Auth::id())
            ->pluck('event_id'); // Mengambil daftar event_id yang aktif untuk user

        $events = Event::with(['sesi' => function ($query) {
            $query->where('status', 'active');
        }])
            ->whereIn('id', $activeEvents) // Filter event berdasarkan event_id dari ModelActiveEvent
            ->where('status', 'on-going') // Hanya event dengan status 'on-going'
            ->get();

        return view('presences.index', compact('events'));
    }

    public function presencesScanner($event, $sesi)
    {
        return view('presences.scanner', compact(['event', 'sesi']));
    }

    public function presencesGetuser($event, $sesi, $qr)
    {
        $user = User::with('dataDiri')->where('code', $qr)->get();
        $cekFirst = ModelActiveEvent::where('event_id', $event)->where('user_id', $user[0]->id)->first();
        return view('presences.show', compact(['event', 'sesi', 'user', 'cekFirst']));
    }

    public function presencesStore($event, $sesi, Request $request)
    {

        $cek = PresenceHistory::where('user_id', $request->user_id)->where('event_id', $event)->where('sesi_id', $sesi)->first();
        if ($cek == null) {
            $data = new PresenceHistory();
            $data->user_id = $request->user_id;
            $data->event_id = $request->event_id;
            $data->sesi_id = $request->sesi_id;
            $data->status = 'Hadir';
            $data->save();
            if ($data->wasRecentlyCreated) {
                return redirect()->route('presences.scanner', compact('event', 'sesi'))->with('success', 'Berhasil Presesni');
            }
            return redirect()->route('presences.scanner', compact('event', 'sesi'))->with('error', 'User Gagal Presensi');
        }
        return redirect()->route('presences.scanner', compact('event', 'sesi'))->with('error', 'User Sudah Presensi');
    }

    public function getPresencesHistory(Request $request)
    {
        // Validate event_id input
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        $eventId = $validated['event_id'];

        // Fetch all sessions for the given event
        $sessions = Sesi::where('event_id', $eventId)->where('grade', 1)->get();

        // If no sessions found, return an error
        if ($sessions->isEmpty()) {
            return response()->json(['error' => 'No sessions found for this event'], 404);
        }

        // Fetch all users and their attendance for the event
        $users = User::with([
            'presenceHistories' => function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            },
            'dataDiri'
        ])->get();

        // Structure the data for frontend display
        $attendance = [];
        foreach ($users as $user) {
            $attendances = $user->presenceHistories->keyBy('sesi_id');

            $attendance[$user->id] = [
                'name' => $user->dataDiri ? $user->dataDiri->name : 'No name available',
                'sessions' => $sessions->map(function ($session) use ($attendances) {
                    $attendanceStatus = $attendances->get($session->id);
                    return $attendanceStatus ? $attendanceStatus->status : 'Belum Absen';
                })
            ];
        }

        return response()->json([
            'sessions' => $sessions,
            'attendance' => $attendance
        ]);
    }
}
