<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Grade;
use App\Models\ModelActiveEvent;
use App\Models\Sesi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    public function index()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->get();
        }
        return view('grade.index', compact('events'));
    }

    public function fetchPeserta(Request $request)
    {
        $eventId = $request->input('event_id');
        $sesis = Sesi::where('event_id', $eventId)->where('grade', 1)->get();

        $modelHasGrades = ModelActiveEvent::where('event_id', $eventId)
            ->whereHas('user', function ($query) {
                $query->role('Peserta');
            })
            ->with(['user.dataDiri', 'event'])
            ->get()
            ->filter(function ($modelActiveEvent) use ($sesis) {
                // For each ModelActiveEvent, check if the user has grades for all sessions
                foreach ($sesis as $sesi) {
                    $gradeExists = Grade::where('user_id', $modelActiveEvent->user_id)
                        ->where('event_id', $modelActiveEvent->event_id)
                        ->where('sesi_id', $sesi->id)
                        ->exists();

                    // If a grade doesn't exist for any session, exclude this user
                    if (!$gradeExists) {
                        return false;
                    }
                }

                // If the user has grades for all sessions, include them in the result
                return true;
            });

        return response()->json($modelHasGrades);
    }

    public function generateDefault($eventId)
    {
        try {
            $modelActiveEvents = ModelActiveEvent::where('event_id', $eventId)->whereHas('user', function ($query) {
                $query->role('Peserta');
            })->with('user.dataDiri')->get();

            $sesis = Sesi::where('event_id', $eventId)->where('grade', 1)->get();

            $allGradesGenerated = true;

            foreach ($modelActiveEvents as $modelActiveEvent) {
                foreach ($sesis as $sesi) {
                    // Check if a grade already exists for this user & session
                    $existingGrade = Grade::where('user_id', $modelActiveEvent->user_id)
                        ->where('event_id', $eventId)
                        ->where('sesi_id', $sesi->id)
                        ->exists();

                    if (!$existingGrade) {
                        // Create a new grade entry
                        $data = new Grade();
                        $data->user_id = $modelActiveEvent->user_id;
                        $data->event_id = $eventId;
                        $data->sesi_id = $sesi->id;
                        $data->save();

                        $allGradesGenerated = false;
                    }
                }
            }

            if ($allGradesGenerated) {
                // If all grades already exist, show a warning message
                return redirect()->route('grades.index')->with('warning', 'Semua user sudah memiliki penilaian untuk semua sesi.');
            }

            // Redirect with success message
            return redirect()->route('grades.index')->with('success', 'Penilaian Berhasil Di Generate');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error generating grades: ' . $e->getMessage());

            // Redirect with error message
            return redirect()->route('grades.index')->with('error', 'Gagal Generate Penilaian');
        }
    }

    public function gradeDelete($userId)
    {
        $data = User::with('dataDiri')->find($userId);
        Grade::where('user_id', $userId)->delete();
        return redirect()->route('grades.index')->with('success', 'Semua Penilaian ' . $data->dataDiri->name . ' Berhasil Dihapuskan');
    }

    public function getSesi($userId, $eventId)
    {
        $user = User::with('dataDiri')->where('code', $userId)->get();
        $sesis = Sesi::where('event_id', $eventId)->where('grade', 1)->get();
        return view('grade.getsesi', compact(['user', 'sesis']));
    }

    public function gradeEdit($userId, $eventId, $sesId)
    {
        $user = User::with('dataDiri')->where('code', $userId)->first();
        $sesis = Grade::with('sesi')->where('sesi_id', $sesId)->where('user_id', $user->id)->where('event_id', $eventId)->get();
        return view('grade.edit', compact(['sesis', 'user']));
    }

    public function update($userId, $eventId, $gradeId, Request $request)
    {
        // Find user by code
        $user = User::where('code', $userId)->first();

        // Handle case where user is not found
        if (!$user) {
            return redirect()->route('grades.getsesi', compact(['userId', 'eventId']))
                ->with('error', 'User not found');
        }
        // Find the grade record
        $data = Grade::where('sesi_id', $gradeId)
            ->where('event_id', $eventId)
            ->where('user_id', $user->id)
            ->first(); // Use first() instead of get()

        // Handle case where grade is not found
        if (!$data) {
            return redirect()->route('grades.getsesi', compact(['userId', 'eventId']))
                ->with('error', 'Grade record not found');
        }
        $data->poin_1 = $request->poin_1;
        $data->poin_2 = $request->poin_2;
        $data->poin_3 = $request->poin_3;
        $data->poin_4 = $request->poin_4;
        if ($data->save()) {
            return redirect()->route('grades.getsesi', compact(['userId', 'eventId']))->with('success', 'Penilaian Berhasil Di Update');
        }
        return redirect()->route('grades.getsesi', compact(['userId', 'eventId']))->with('success', 'Penilaian Gagal Di Update');
    }
}
