<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ModelActiveEvent;
use App\Models\ModelRequestRole;
use App\Models\PresenceHistory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    public function dashboard()
    {
        $submission = ModelRequestRole::where('user_id', Auth::id())->latest()->first();
        return view('dashboard', compact('submission'));
    }

    public function storeRequestRole(Request $request)
    {
        $submission = new ModelRequestRole();
        $submission->user_id = Auth::id();
        $submission->requested_role = 'Admin';
        $submission->reason = $request->reason;
        $submission->save();

        if ($submission->wasRecentlyCreated) {
            return redirect()->route('dashboard')->with('success', 'Pengajuan Berhasil Di Simpan');
        } else {
            return redirect()->route('dashboard')->with('error', 'Pengajuan Gagal DiSimpan');
        };
    }

    public function fetchUserJoined(Request $request)
    {
        $eventId = $request->input('event_id');
        $modelActiveEvent = ModelActiveEvent::where('event_id', $eventId)
            ->with(['user.dataDiri', 'event'])
            ->get();


        return response()->json($modelActiveEvent);
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
        return view('presences.show', compact(['event', 'sesi', 'user']));
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
}
