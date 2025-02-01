<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\PresenceHistory;
use Illuminate\Http\Request;
use App\Models\ModelActiveEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PresenceHistoryController extends Controller
{
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
        $cekFirst = ModelActiveEvent::where('event_id', $event)->where('user_id', $user[0]->id())->first();
        dd($cekFirst);
        if ($cekFirst) {
            return redirect()->route('presences.scanner', compact('event', 'sesi'))->with('error', 'User Belum Bergabung Silahkan Lakukan Undang Terlebih Dahulu');
        }
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
