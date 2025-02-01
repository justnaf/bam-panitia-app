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
        $dataPeserta = ModelActiveEvent::with('user.dataDiri')
            ->where('event_id', $event_id)
            ->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'Peserta');
                });
            })
            ->get();

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
        $dataPeserta = ModelActiveEvent::with('user.orgHistories')->where('event_id', $event_id)->whereHas('user', function ($query) {
            $query->whereHas('roles', function ($roleQuery) {
                $roleQuery->where('name', 'Peserta');
            });
        })->get();

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

    public function getOwnPaper($event_id)
    {
        $dataPeserta = ModelActiveEvent::with('user.OwnPaper')->where('event_id', $event_id)->whereHas('user', function ($query) {
            $query->whereHas('roles', function ($roleQuery) {
                $roleQuery->where('name', 'Peserta');
            });
        })->get();
        // Initialize counters
        $paperCount1 = 0;
        $paperCount2 = 0;
        $paperCount3 = 0;
        $paperCount4 = 0;
        $paperCount5 = 0;

        // Loop through the participants and count gender and orgHistories
        foreach ($dataPeserta as $peserta) {
            // Get the count of orgHistories for each user
            $paperHistoryCount = $peserta->user->OwnPaper->count();

            // Limit the count to a maximum of 5
            if ($paperHistoryCount > 5) {
                $paperHistoryCount = 5;
            }

            // Count the gender and the organization count
            if ($peserta->user->dataDiri->gender == 'Laki-laki') {
                if ($paperHistoryCount == 1) {
                    $paperCount1++;
                } elseif ($paperHistoryCount == 2) {
                    $paperCount2++;
                } elseif ($paperHistoryCount == 3) {
                    $paperCount3++;
                } elseif ($paperHistoryCount == 4) {
                    $paperCount4++;
                } elseif ($paperHistoryCount == 5) {
                    $paperCount5++;
                }
            } elseif ($peserta->user->dataDiri->gender == 'Perempuan') {
                if ($paperHistoryCount == 1) {
                    $paperCount1++;
                } elseif ($paperHistoryCount == 2) {
                    $paperCount2++;
                } elseif ($paperHistoryCount == 3) {
                    $paperCount3++;
                } elseif ($paperHistoryCount == 4) {
                    $paperCount4++;
                } elseif ($paperHistoryCount == 5) {
                    $paperCount5++;
                }
            }
        }

        // Return only the counts, not the full response
        return [
            '1 Paper' => $paperCount1,
            '2 Paper' => $paperCount2,
            '3 Paper' => $paperCount3,
            '4 Paper' => $paperCount4,
            '5+ Paper' => $paperCount5,  // Combine 5 or more into one group
        ];
    }

    public function getReadInterest($event_id)
    {
        // Define categories
        $categories = [
            'antologi',
            'biografi',
            'dongeng',
            'ensiklopedi',
            'jurnal',
            'komik',
            'agama',
            'novel',
            'sejarah',
            'lain-lain'
        ];

        // Initialize category counters
        $categoryCounts = array_fill_keys($categories, 0);

        // Fetch participants with their Read Interests
        $dataPeserta = ModelActiveEvent::with('user.ReadInterest')
            ->where('event_id', $event_id)->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'Peserta');
                });
            })
            ->get();

        // Loop through participants and count read interests per category
        foreach ($dataPeserta as $peserta) {
            foreach ($peserta->user->ReadInterest as $readIn) {
                $type = strtolower($readIn->type); // Normalize category names

                if (array_key_exists($type, $categoryCounts)) {
                    $categoryCounts[$type]++;
                } else {
                    $categoryCounts['lain-lain']++; // Count unknown types in "lain-lain"
                }
            }
        }

        // Return the count per category
        return response()->json($categoryCounts);
    }

    public function getTopParticipant($event_id)
    {
        $dataPeserta = ModelActiveEvent::with(['user.dataDiri', 'user.grades'])  // Ensure grades relationship is correctly loaded
            ->where('event_id', $event_id)
            ->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'Peserta');
                });
            })
            ->get()
            ->map(function ($peserta) {
                // Fetch grades for the user, or use an empty collection if none exist
                $grades = $peserta->user->grades ?? collect();
                $totalSesi = $grades->count();

                // If no grades, set score to 0
                if ($totalSesi == 0) {
                    $overall_score = 0;
                } else {
                    // Calculate total points from all grades (poin_1, poin_2, poin_3, poin_4)
                    $totalPoin = $grades->sum(function ($grade) {
                        return ($grade->poin_1 + $grade->poin_2 + $grade->poin_3 + $grade->poin_4);
                    });

                    // Calculate overall score as the total points divided by the maximum points possible
                    $overall_score = $totalPoin / ($totalSesi * 4);  // Assuming each session has a max of 4 points
                }

                return [
                    'name' => $peserta->user->dataDiri->name ?? 'Unknown',
                    'npm' => $peserta->user->username,
                    'gender' => $peserta->user->dataDiri->gender ?? 'Unknown',
                    'overall_score' => $overall_score,
                ];
            });

        $topMale = $dataPeserta->where('gender', 'Laki-laki')->sortByDesc('overall_score')->take(5)->values();
        $topFemale = $dataPeserta->where('gender', 'Perempuan')->sortByDesc('overall_score')->take(5)->values();

        return response()->json([
            'laki_laki' => $topMale,
            'perempuan' => $topFemale,
        ]);
    }

    public function getSummaryData(Request $request)
    {
        $genderData = $this->getPeserta($request->event_id);
        $orgData = $this->getOrg($request->event_id);
        $paperData = $this->getOwnPaper($request->event_id);
        $readInData = $this->getReadInterest($request->event_id);
        $topData = $this->getTopParticipant($request->event_id);

        // Return the data as a combined response
        return response()->json([
            'gender' => $genderData,
            'org' => $orgData,
            'paper' => $paperData,
            'readIn' => $readInData,
            'top' => $topData
        ]);
    }
}
