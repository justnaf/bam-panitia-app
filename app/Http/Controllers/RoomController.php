<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\ModelActiveEvent;
use App\Models\ModelHasRestroom;
use App\Models\RestRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RoomController extends Controller
{
    public function index()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->where('status', '!=', 'done')->get();
        }
        return view('restroom.room.index', compact('events'));
    }

    public function indexDistribute()
    {
        $modelActiveEvent = ModelActiveEvent::where('user_id', Auth::id())->pluck('event_id');
        if (Auth::user()->roles->pluck('name')[0] == 'SuperAdmin') {
            $events = Event::all();
        } else {
            $events = Event::whereIn('id', $modelActiveEvent)->where('status', '!=', 'done')->get();
        }
        return view('restroom.modelroom.index', compact('events'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'event_id' => 'required'
        ], [
            'event_id.required' => 'Event Belum Di pilih.',
        ]);
        $eventId = $request->query('event_id');
        $event = Event::find($eventId);
        return view('restroom.room.create', compact('event'));
    }

    public function store(Request $request)
    {
        $data = new RestRoom();
        $data->code = uniqid();
        $data->event_id = $request->event_id;
        $data->name = $request->name;
        $data->capacity = $request->capacity;
        $data->gender = $request->gender;
        $data->save();
        if ($data->wasRecentlyCreated) {
            return redirect()->route('restroom.index')->with('success', 'Berhasil Menambahkan Kamar');
        }
        return redirect()->route('restroom.index')->with('error', 'Gagal Menambahkan Kamar');
    }

    public function storeDistribute(Request $request)
    {
        $roomId = $request->rest_room_id;
        $data = new ModelHasRestroom();
        $data->event_id = $request->event_id;
        $data->user_id = $request->user_id;
        $data->rest_room_id =  $roomId;
        $data->save();
        if ($data->wasRecentlyCreated) {
            return redirect()->route('restroom.editDistri', compact('roomId'))->with('success', 'Berhasil Menambahkan Peserta Pada Kamar');
        }
        return redirect()->route('restroom.editDistri', compact('roomId'))->with('error', 'Gagal Menambahkan Peserta Pada Kamar');
    }


    public function editRooms(RestRoom $roomId)
    {
        return view('restroom.room.edit', compact('roomId'));
    }

    public function editDistribute(RestRoom $roomId)
    {
        return view('restroom.modelroom.edit', compact('roomId'));
    }

    public function deleteRooms(RestRoom $roomId)
    {
        // Hapus data sesi setelah file berhasil dihapus
        if ($roomId->delete()) {
            return redirect()->route('restroom.index')->with('success', 'Kamar Berhasil Dihapus');
        } else {
            return redirect()->route('restroom.index')->with('error', 'Kamar Gagal Dihapus.');
        }
    }

    public function deleteModelHasRoom($roomId, ModelHasRestroom $modelHasRoom)
    {
        // Hapus data sesi setelah file berhasil dihapus
        if ($modelHasRoom->delete()) {
            return redirect()->route('restroom.editDistri', compact('roomId'))->with('success', 'Data Peserta Pada Kamar Berhasil Dihapus');
        } else {
            return redirect()->route('restroom.editDistri', compact('roomId'))->with('error', 'Data Peserta Pada Kamar Gagal Dihapus.');
        }
    }

    public function updateRooms(RestRoom $roomId, Request $request)
    {
        $roomId->name = $request->name;
        $roomId->capacity = $request->capacity;
        $roomId->gender = $request->gender;
        if ($roomId->save()) {
            return redirect()->route('restroom.index')->with('success', 'Berhasil Update Kamar');
        }
        return redirect()->route('restroom.index')->with('error', 'Gagal Update Kamar');
    }

    public function getRooms(Request $request)
    {
        $rooms = RestRoom::where('event_id', $request->event_id)->get();

        return response()->json([
            'data' => $rooms->isEmpty() ? [] : $rooms
        ]);
    }

    public function getDistribute(Request $request)
    {
        $rooms = RestRoom::with('modelHasRestroom')->where('event_id', $request->event_id)->get();

        return response()->json([
            'data' => $rooms->isEmpty() ? [] : $rooms
        ]);
    }

    public function getJoin(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'rest_room_id' => 'required|integer|exists:rest_rooms,id'
        ]);

        $peserta = ModelHasRestroom::with('user.dataDiri')->where('event_id', $request->event_id)->where('rest_room_id', $request->rest_room_id)->get();

        return response()->json([
            'data' => $peserta
        ]);
    }

    public function getUnjoin(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'gender' => 'required|string|in:Laki-laki,Perempuan'
        ]);

        $peserta = ModelActiveEvent::with('user.dataDiri')
            ->whereHas('user', function ($query) use ($request) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'Peserta');
                })->whereHas('dataDiri', function ($dataDiriQuery) use ($request) {
                    $dataDiriQuery->where('gender', $request->gender);
                })->whereDoesntHave('modelHasRestroom'); // Exclude users who already have a room
            })
            ->where('event_id', $request->event_id)
            ->get();

        return response()->json([
            'data' => $peserta
        ]);
    }

    public function randomizeRoom(Request $request)
    {
        $request->validate([
            'event_id' => 'required'
        ], [
            'event_id.required' => 'Event Belum Dipilih.',
        ]);

        $eventId = $request->query('event_id');

        $restRooms = RestRoom::where('event_id', $eventId)->get();

        if ($restRooms->isEmpty()) {
            return redirect()->route('restroom.indexDistri')->with('error', 'Tidak ada kamar tersedia untuk event ini.');
        }

        $dataPeserta = ModelActiveEvent::with('user.dataDiri')
            ->where('event_id', $eventId)
            ->whereHas('user', function ($query) {
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('name', 'Peserta');
                })->whereDoesntHave('modelHasRestroom'); // Cek jika user belum punya kamar
            })
            ->get();

        if ($dataPeserta->isEmpty()) {
            return redirect()->route('restroom.indexDistri')->with('warning', 'Semua peserta sudah memiliki kamar.');
        }

        $dataPeserta = $dataPeserta->shuffle();

        foreach ($dataPeserta as $peserta) {
            // Pilih kamar yang sesuai dengan gender peserta dan masih memiliki kapasitas
            $matchingRooms = $restRooms->filter(function ($room) use ($peserta) {
                $currentOccupants = ModelHasRestroom::where('rest_room_id', $room->id)->count();
                return $room->gender === $peserta->user->dataDiri->gender && $currentOccupants < $room->capacity;
            });

            if ($matchingRooms->isEmpty()) {
                continue; // Lewati jika tidak ada kamar yang sesuai dengan gender dan kapasitas peserta
            }

            $randomRoom = $matchingRooms->random(); // Pilih kamar secara acak dari yang sesuai

            // Simpan ke tabel ModelHasRestroom
            ModelHasRestroom::create([
                'user_id' => $peserta->user_id,
                'rest_room_id' => $randomRoom->id,
                'event_id' => $eventId
            ]);
        }

        return redirect()->route('restroom.indexDistri')->with('success', 'Peserta berhasil diacak ke kamar yang sesuai dengan gender.');
    }
}
