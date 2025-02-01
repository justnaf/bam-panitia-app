<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col space-x-7 justify-center items-center w-full mb-3">
                        <form method="POST" action="{{route('presences.store',['event' => $event,'sesi' => $sesi])}}" class="text-center">
                            @csrf
                            @foreach ($user as $item)
                            @if(!$cekFirst)
                            @else
                            <div class="bg-gray-300 shadow-lg p-4 w-64 h-80 flex items-center justify-center mb-3">
                                <img src="{{url('https://peserta.siaruna.com//storage/'.$item->dataDiri->profile_picture)}}" alt="{{$item->dataDiri->name}}" class="h-64 object-cover">
                            </div>
                            @endif
                            <h1 class="font-extrabold text-lg">{{$item->dataDiri->name}}</h1>
                            <h1 class="font-extrabold text-lg">{{$item->username}}</h1>
                            <input type="text" name="user_id" hidden value="{{$item->id}}">
                            @endforeach
                            @if(!$cekFirst)
                            <div class="mb-2">
                                <p>User Belum Join Kegiatan</p>
                            </div>
                            <a href="{{route('presences.scanner',['event'=>$event,'sesi'=>$sesi])}}" class="bg-emerald-500 px-2 py-2 rounded-md mt-6 text-white">Kembali Ke Scanner</a>
                            @else
                            <input type="text" name="event_id" hidden value="{{$event}}">
                            <input type="text" name="sesi_id" hidden value="{{$sesi}}">
                            <button type="submit" class="bg-emerald-500 px-2 py-1 rounded-md text-white hover:bg-blue-500 font-extrabold">Hadir</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
