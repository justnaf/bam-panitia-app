<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventSumController extends Controller
{
    public function eventSummary()
    {
        $events = Event::where('user_id', Auth::id())->get();
        return view('summary.index', compact('events'));
    }

    public function getPeserta(Request $request)
    {
        dd($request);
    }
}
