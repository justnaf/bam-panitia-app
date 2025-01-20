<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('events.index')}}">Events Management</a> > <span>Show</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <a href="{{route('events.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-bold text-2xl mb-3">Data Kegiatan</h1>
                    <div class="max-w-lg mx-auto">
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Nama Kegiatan
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->name}}" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="institution">
                                    Penyelenggara
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->institution}}" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location">
                                    Lokasi
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->location}}" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Link Gmaps Lokasi
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->location_url}}" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Tanggal Mulai
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->start_date}}" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Tanggal Selesai
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->end_date}}" disabled />
                            </div>
                            <div class="w-full px-1  col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Maksimum Peserta
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->max_person}}" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Penanggung Jawab
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->pic}}" disabled />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Email Penanggung Jawab
                                </label>
                                <input class="block w-full border border-slate-300 rounded-md p-2 shadow-sm bg-slate-200 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300 sm:text-sm" value="{{$event->email}}" disabled />
                            </div>
                        </div>
                    </div>
                    @if($event->status == 'draft'||$event->status == 'submission')

                    @else
                    <hr class="border-b-1 border-gray-400 my-4 mx-auto max-w-lg mt-5">
                    <h1 class="text-center font-bold text-2xl mb-3">Sesi Kegiatan</h1>
                    <p class="text-center">Coming Soon</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
