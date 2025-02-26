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
                    <div class="max-w-2xl mx-auto" x-data="eventHandler({{ $event->first()->id ?? 'null' }})" x-init="init()">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">Nama</th>
                                    <th class="px-2 py-3">CV</th>
                                    <th class="px-2 py-3">Materi</th>
                                    <th class="px-2 py-3">Narasumber</th>
                                    <th class="px-2 py-3">Ruangan</th>
                                    <th class="px-2 py-3">Waktu</th>
                                    <th class="px-2 py-3">Status</th>
                                </tr>
                            </thead>
                            <!-- Grouped sessions -->
                            <template x-if="Object.keys(groupedSessions).length > 0">
                                <template x-for="(group, day) in groupedSessions" :key="day">
                                    <tbody>
                                        <!-- Day Header -->
                                        <tr class="bg-gray-400 text-lg text-slate-50 font-bold">
                                            <td colspan="8" class="px-3" x-text="day"></td>
                                        </tr>

                                        <!-- Sessions for the day -->
                                        <template x-for="(session, index) in group" :key="session.id">
                                            <tr class="border-b">
                                                <td class="px-2 py-3" x-text="session.name"></td>
                                                <td class="px-2 py-3">
                                                    <template x-if="session.cv_path">
                                                        <a :href="`{{ asset('storage/') }}/${session.cv_path}`" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded inline-flex items-center" download>
                                                            <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                                            </svg>
                                                        </a>
                                                    </template>
                                                    <template x-if="!session.cv_path">
                                                        <span>No File</span>
                                                    </template>
                                                </td>
                                                <td class="px-2 py-3">
                                                    <template x-if="session.materi_path">
                                                        <a :href="`{{ asset('storage/') }}/${session.materi_path}`" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-3 rounded inline-flex items-center" download>
                                                            <svg class="fill-current w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                                            </svg>
                                                        </a>
                                                    </template>
                                                    <template x-if="!session.materi_path">
                                                        <span>No File</span>
                                                    </template>
                                                </td>
                                                <td class="px-2 py-3" x-text="session.speaker"></td>
                                                <td class="px-2 py-3" x-text="session.room"></td>
                                                <td class="px-2 py-3" x-text="session.time.split(',')[1].trim()"></td>
                                                <td class="px-2 py-3" x-text="session.status"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </template>
                            </template>
                            <!-- No sessions available -->
                            <template x-if="Object.keys(groupedSessions).length === 0">
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center p-3">No Sesi Display</td>
                                    </tr>
                                </tbody>
                            </template>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function eventHandler(initialEventId) {
            return {
                selectedEvent: initialEventId
                , sessions: []
                , groupedSessions: {}, // Cache grouped sessions

                init() {
                    if (this.selectedEvent) {
                        console.log('Initializing fetchSessions for event:', this.selectedEvent); // Debugging log
                        this.fetchSessions();
                    }
                },

                fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/sessions', {
                                method: 'POST'
                                , headers: {
                                    'Content-Type': 'application/json'
                                    , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                                , body: JSON.stringify({
                                    event_id: this.selectedEvent
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                this.sessions = data;
                                this.groupedSessions = this.groupByDay(data); // Cache the grouped data
                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.sessions = [];
                        this.groupedSessions = {}; // Reset grouped data
                    }
                },

                groupByDay(sessions) {
                    const grouped = sessions.reduce((result, session) => {
                        const [day, time] = session.time ? session.time.split(',') : ['Unknown Day', 'Unknown Time'];
                        const trimmedDay = day.trim(); // Clean up extra spaces
                        const trimmedTime = time ? time.trim() : 'Unknown Time';

                        if (!result[trimmedDay]) result[trimmedDay] = [];
                        result[trimmedDay].push({
                            ...session
                            , time: `${trimmedDay}, ${trimmedTime}`
                        });
                        return result;
                    }, {});
                    Object.keys(grouped).forEach(day => {
                        grouped[day].sort((a, b) => {
                            const timeA = a.time.split(',')[1].trim(); // Extract time
                            const timeB = b.time.split(',')[1].trim();

                            // Parse times to compare
                            const [hourA, minuteA] = timeA.split(':').map(Number);
                            const [hourB, minuteB] = timeB.split(':').map(Number);

                            return hourA - hourB || minuteA - minuteB; // Compare hours and minutes
                        });
                    });
                    return grouped;
                }
            }
        }

    </script>


    </script>
    @endpush
</x-app-layout>
