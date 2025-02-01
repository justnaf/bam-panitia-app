<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ModelActiveEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;

class EventSumController extends Controller
{
    public function eventSummary()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->get();
        }
        return view('summary.index', compact('events'));
    }

    public function getPeserta($event_id)
    {
        $dataPeserta = ModelActiveEvent::with('user.dataDiri')->where('event_id', $event_id)->where('status', 'Peserta')->get();

        // Initialize counters
        $lakiLakiCount = 0;
        $perempuanCount = 0;

        // Loop through the participants and count gender
        foreach ($dataPeserta as $peserta) {
            if ($peserta->user->dataDiri->gender === 'Laki-laki') {
                $lakiLakiCount++;
            } elseif ($peserta->user->dataDiri->gender === 'Perempuan') {
                $perempuanCount++;
            }
        }

        // Return only the counts, not the full response
        return [
            'Laki-laki' => $lakiLakiCount,
            'Perempuan' => $perempuanCount,
        ];
    }

    public function getOrg($event_id)
    {
        $dataPeserta = ModelActiveEvent::with('user.orgHistories')->where('event_id', $event_id)->get();

        // Initialize counters
        $orgCount1 = 0;
        $orgCount2 = 0;
        $orgCount3 = 0;
        $orgCount4 = 0;
        $orgCount5 = 0;

        // Loop through the participants and count gender and orgHistories
        foreach ($dataPeserta as $peserta) {
            // Get the count of orgHistories for each user
            $orgHistoryCount = $peserta->user->orgHistories->count();

            // Limit the count to a maximum of 5
            if ($orgHistoryCount > 5) {
                $orgHistoryCount = 5;
            }

            // Count the gender and the organization count
            if ($peserta->user->dataDiri->gender == 'Laki-laki') {
                if ($orgHistoryCount == 1) {
                    $orgCount1++;
                } elseif ($orgHistoryCount == 2) {
                    $orgCount2++;
                } elseif ($orgHistoryCount == 3) {
                    $orgCount3++;
                } elseif ($orgHistoryCount == 4) {
                    $orgCount4++;
                } elseif ($orgHistoryCount == 5) {
                    $orgCount5++;
                }
            } elseif ($peserta->user->dataDiri->gender == 'Perempuan') {
                if ($orgHistoryCount == 1) {
                    $orgCount1++;
                } elseif ($orgHistoryCount == 2) {
                    $orgCount2++;
                } elseif ($orgHistoryCount == 3) {
                    $orgCount3++;
                } elseif ($orgHistoryCount == 4) {
                    $orgCount4++;
                } elseif ($orgHistoryCount == 5) {
                    $orgCount5++;
                }
            }
        }

        // Return only the counts, not the full response
        return [
            '1 Organisasi' => $orgCount1,
            '2 Organisasi' => $orgCount2,
            '3 Organisasi' => $orgCount3,
            '4 Organisasi' => $orgCount4,
            '5+ Organisasi' => $orgCount5,  // Combine 5 or more into one group
        ];
    }

    public function getSummaryData(Request $request)
    {
        $genderData = $this->getPeserta($request->event_id);  // Call your existing getPeserta method
        $orgData = $this->getOrg($request->event_id);  // Call your existing getOrg method

        // Return the data as a combined response
        return response()->json([
            'gender' => $genderData,
            'org' => $orgData
        ]);
    }
}
