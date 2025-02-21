<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presensi Kajian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col space-x-7 justify-center items-center w-full mb-3">
                        <h1 class="mb-2 font-extrabold text-lg">Presensi Untuk Kajian : {{$kajian->name}}</h1>
                        <form method="POST" action="{{route('presences.majelis.store',$kajian->id)}}" class="text-center">
                            @csrf
                            @foreach ($user as $item)
                            <div class="bg-gray-300 shadow-lg p-4 w-64 h-80 flex items-center justify-center mb-3">
                                <img src="{{url('https://peserta.siaruna.com/storage/'.$item->dataDiri->profile_picture)}}" alt="{{$item->dataDiri->name}}" class="h-64 object-cover">
                            </div>
                            <h1 class="font-extrabold text-lg">{{$item->dataDiri->name}}</h1>
                            <h1 class="font-extrabold text-lg">{{$item->username}}</h1>
                            <input type="text" name="user_id" hidden value="{{$item->id}}">
                            @endforeach
                            <input type="text" name="majelis_id" hidden value="{{$kajian->id}}">
                            <div class="w-full px-1 mb-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="status">
                                    Status Kedatangan
                                </label>
                                <select class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="status" id="status" required>
                                    <option selected>-- Silahkan Pilih Kehadiran--</option>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Telat">Telat</option>
                                </select>
                            </div>
                            <div class="w-full px-1 mb-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="status">
                                    Status Hadir Kajian
                                </label>
                                <select class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="desc" id="desx" required>
                                    <option selected>-- Pilih--</option>
                                    <option value="RTL BAM">RTL BAM</option>
                                    <option value="RTL">RTL</option>
                                    <option value="Non-RTL">Non-RTL</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-emerald-500 px-2 py-1 rounded-md text-white hover:bg-blue-500 font-extrabold">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
