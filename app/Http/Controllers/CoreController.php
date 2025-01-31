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
}
