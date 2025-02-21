<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Grade;
use App\Models\ModelActiveEvent;
use App\Models\ModelHistoryEvent;
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
            $events = Event::whereIn('id', $modelActiveEvent)->where('status', '!=', 'done')->get();
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
        $grades = Grade::with('sesi')->where('sesi_id', $sesId)->where('user_id', $user->id)->where('event_id', $eventId)->get();

        return view('grade.edit', compact(['grades', 'user']));
    }

    public function update($userId, $eventId, Grade $gradeId, Request $request)
    {
        $data = $gradeId;
        $data->poin_1 = $request->poin_1;
        $data->poin_2 = $request->poin_2;
        $data->poin_3 = $request->poin_3;
        $data->poin_4 = $request->poin_4;
        if ($data->save()) {
            return redirect()->route('grades.getsesi', compact(['userId', 'eventId']))->with('success', 'Penilaian Berhasil Di Update');
        }
        return redirect()->route('grades.getsesi', compact(['userId', 'eventId']))->with('success', 'Penilaian Gagal Di Update');
    }

    public function indexGraduate()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->where('status', '!=', 'done')->get();
        }

        return view('graduate.index', compact('events'));
    }

    public function fetchGraduateData(Request $request)
    {
        $modeHistEvent = ModelHistoryEvent::where('event_id', $request->event_id)->with(['user.dataDiri', 'event'])->get();
        return response()->json([
            'history' => $modeHistEvent
        ]);
    }

    public function genereteAllGraduate($eventId)
    {
        $modelActiveEvents = ModelActiveEvent::where('event_id', $eventId)->with('event')->get();
        $eventName = Event::find($eventId)->name;

        $allExisting = true;

        foreach ($modelActiveEvents as $activeEvent) {
            $existingGraduate = ModelHistoryEvent::where('user_id', $activeEvent->user_id)
                ->where('event_id', $activeEvent->event_id)
                ->first();

            if (!$existingGraduate) {
                $allExisting = false;
                $graduate = new ModelHistoryEvent();
                $graduate->user_id = $activeEvent->user_id;
                $graduate->event_id = $activeEvent->event_id;
                $graduate->joined_as = $activeEvent->status;
                $graduate->status = 'Lulus';
                $graduate->desc = 'Tanpa Catatan';
                $graduate->save();
            }
        }
        if ($allExisting) {
            return redirect()->route('grades.graduate.index')
                ->with('info', 'Semua pengguna dalam kegiatan ' . $eventName . ' sudah memiliki status kelulusan.');
        }
        return redirect()->route('grades.graduate.index')
            ->with('success', 'Sukses Memberikan Status Kelulusan Untuk Kegiatan ' . $eventName);
    }

    public function editGraduateData(ModelHistoryEvent $graduateId)
    {
        $graduate = $graduateId;
        return view('graduate.edit', compact('graduate'));
    }

    public function updateGraduateData(ModelHistoryEvent $graduateId, Request $request)
    {
        $graduateId->status = $request->status;
        $graduateId->desc = $request->desc;
        if ($graduateId->save()) {
            return redirect()->route('grades.graduate.index')->with('success', 'Data Kelulusan Berhasil Dirubah');
        }
        return redirect()->route('grades.graduate.index')->with('error', 'Data Kelulusan Gagal Dirubah');
    }
}
