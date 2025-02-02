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
            $events = Event::whereIn('id', $modelActiveEvent)->where('status', '!=', 'done')->get();
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
                return redirect()->route('presences.scanner', compact('event', 'sesi'))->with('success', 'Berhasil Presensi');
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
        $users = User::role('Peserta')->whereHas('modelActiveEvent', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })->with([
            'presenceHistories' => function ($query) use ($eventId) {
                $query->where('event_id', $eventId);
            },
            'dataDiri'
        ])->get();

        // Structure the data for frontend display
        $attendance = [];
        $counter = 1;
        foreach ($users as $user) {
            $attendances = $user->presenceHistories->keyBy('sesi_id');

            $attendance[$user->id] = [
                'index' => $counter++,  // Add an index
                'id' => $user->id,
                'npm' => $user->username,
                'name' => $user->dataDiri ? $user->dataDiri->name : 'No name available',
                'sessions' => $sessions->map(function ($session) use ($attendances) {
                    $attendanceStatus = $attendances->get($session->id);
                    return [
                        'session_id' => $session->id,  // Tambahkan session_id
                        'status' => $attendanceStatus ? $attendanceStatus->status : 'Belum Absen'
                    ];
                })->toArray()
            ];
        }

        return response()->json([
            'sessions' => $sessions,
            'attendance' => $attendance
        ]);
    }
    public function updateStatus(Request $request)
    {
        $statuses = ['Tidak Hadir', 'Hadir', 'Telat', 'Sakit', 'Izin'];
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'sesi_id' => 'required|exists:sesis,id',
        ]);
        $cekFirst = PresenceHistory::where('user_id', $request->user_id)->where('event_id', $request->event_id)->where('sesi_id', $request->sesi_id)->first();

        if (!$cekFirst) {
            $presence = new PresenceHistory();
            $presence->event_id = $request->event_id;
            $presence->user_id = $request->user_id;
            $presence->sesi_id = $request->sesi_id;
            $presence->status = 'Tidak Hadir';
            $presence->save();
            if ($presence->wasRecentlyCreated) {
                return redirect()->route('presences.listview')->with('success', 'Berhasil Update Presensi');
            }
        } else {
            $currentStatus = $cekFirst->status;

            $currentStatusIndex = array_search($currentStatus, $statuses);

            if ($currentStatusIndex !== false) {
                $nextStatus = $statuses[($currentStatusIndex + 1) % count($statuses)];

                $cekFirst->update(['status' => $nextStatus]);
            }
        }
        return redirect()->route('presences.listview')->with('error', 'Gagal Update Presensi');
    }
}
