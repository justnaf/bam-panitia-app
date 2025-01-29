<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sesi Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')

            <div class="mx-auto" x-data="eventHandler({{ $events->first()->id ?? 'null' }})" x-init="init()">
                <div class="mb-5">
                    <label for="eventSelect" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Kegiatan</label>
                    <select id="eventSelect" @change="fetchSessions()" x-model="selectedEvent" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" selected>Choose an Event</option>
                        @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('event_id')" class="mt-2" />
                </div>

                <a :href="'{{ route('sesi.create') }}?event_id=' + selectedEvent" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <input type="text" name="event_id" hidden x-model="selectedEvent">
                    Tambah Sesi
                </a>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">#</th>
                                    <th class="px-2 py-3">Nama</th>
                                    <th class="px-2 py-3">CV</th>
                                    <th class="px-2 py-3">Materi</th>
                                    <th class="px-2 py-3">Narasumber</th>
                                    <th class="px-2 py-3">Ruangan</th>
                                    <th class="px-2 py-3">Waktu</th>
                                    <th class="px-2 py-3">Status</th>
                                    <th class="px-2 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <!-- Grouped sessions -->
                            <template x-if="Object.keys(groupedSessions).length > 0">
                                <template x-for="(group, day) in groupedSessions" :key="day">
                                    <tbody>
                                        <!-- Day Header -->
                                        <tr class="bg-gray-400 text-lg text-slate-50 font-bold">
                                            <td colspan="9" class="px-3" x-text="day"></td>
                                        </tr>

                                        <!-- Sessions for the day -->
                                        <template x-for="(session, index) in group" :key="session.id">
                                            <tr class="border-b">
                                                <td class="px-2 py-3" x-text="index + 1"></td>
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
                                                <td class="px-2 py-3">
                                                    <a :href="'cnsession-status/'+session.id" x-text="session.status.charAt(0).toUpperCase() + session.status.slice(1)" class="border-2 rounded-md text-center hover:bg-slate-200 border-gray-200 py-2 px-4"></a>
                                                </td>
                                                <td class="px-2 py-3">
                                                    <form method="POST" :action="'/sesi/' + session.id" x-data="deleteForm" x-ref="form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="hover:text-red-500" @click="confirmDelete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </template>
                            </template>
                            <!-- No sessions available -->
                            <template x-if="Object.keys(groupedSessions).length === 0">
                                <tbody>
                                    <td colspan="9" class="text-center p-3">No Sesi Display</td>
                                </tbody>
                            </template>
                        </table>
                    </div>
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

        function deleteForm() {
            return {
                confirmDelete() {
                    Swal.fire({
                        title: 'Are you sure?'
                        , text: "Yakin Ingin Menghapus Data Ini!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes, delete it!'
                        , cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$refs.form.submit();
                        }
                    });
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
