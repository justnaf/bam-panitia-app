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

    public function diseases()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->where('status', '!=', 'done')->get();
        }
        return view('kesehatan.disease', compact('events'));
    }

    public function alergics()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->where('status', '!=', 'done')->get();
        }
        return view('kesehatan.alergic', compact('events'));
    }

    public function getDiseases(Request $request)
    {
        // Ambil semua user yang terkait dengan event tertentu
        $users = User::whereHas('modelActiveEvent', function ($query) use ($request) {
            $query->where('event_id', $request->event_id);
        })->whereHas('diseases')->with(['diseases', 'dataDiri'])->get();

        // Format response JSON
        return response()->json([
            'users' => $users
        ]);
    }
    public function getAlergic(Request $request)
    {
        // Ambil semua user yang terkait dengan event tertentu
        $users = User::whereHas('modelActiveEvent', function ($query) use ($request) {
            $query->where('event_id', $request->event_id);
        })->with(['alergics', 'dataDiri'])->get();

        // Format response JSON
        return response()->json([
            'users' => $users
        ]);
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
}
