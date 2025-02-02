<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            History Presensi
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto px-2">
            <a href="{{ route('presences.index') }}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-5">
                Buka QR Scanner Presensi
            </a>
            <div class="mx-auto" x-data="eventHandler({{ $events->first()->id ?? 'null' }})" x-init="init()">
                <div class="mb-5 mt-4">
                    <label for="eventSelect" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Kegiatan</label>
                    <select id="eventSelect" @change="fetchSessions()" x-model="selectedEvent" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                        <option value="" selected>Choose an Event</option>
                        @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('event_id')" class="mt-2" />
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-4 py-2">#</th>
                                    <th class="px-4 py-2">NPM</th>
                                    <th class="px-4 py-2">Nama Mahasiswa</th>
                                    <template x-for="session in sessions" :key="session.id">
                                        <th class="px-4 py-2" x-text="session.name"></th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(student, index) in sortedAttendance()" :key="student.id ?? index">
                                    <tr class="border-b">
                                        <!-- Kolom Nomor Urut -->
                                        <td class="px-4 py-2" x-text="student.index"></td> <!-- Display the index -->
                                        <td class="px-4 py-2" x-text="student.npm"></td>
                                        <td class="px-4 py-2" x-text="student.name"></td>
                                        <template x-for="(session, sessionIndex) in student.sessions" :key="session.session_id">
                                            <td class="px-4 py-2 text-center cursor-pointer border" :class="{
                                                    'bg-red-500 text-white': session.status === 'Tidak Hadir',
                                                    'bg-emerald-600 text-white': session.status === 'Hadir',
                                                    'bg-yellow-500 text-gray-400': session.status === 'Telat',
                                                    'bg-blue-500 text-gray-300': session.status === 'Sakit',
                                                    'bg-orange-500 text-gray-100': session.status === 'Izin'
                                                }">
                                                <form :action="`/presences/update-presence-status`" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="user_id" :value="student.id">
                                                    <input type="hidden" name="sesi_id" :value="session.session_id">
                                                    <input type="hidden" name="event_id" :value="selectedEvent">
                                                    <button type="submit" class="w-full h-full bg-transparent border-none cursor-pointer">
                                                        <span x-text="session.status"></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
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
                , attendance: {}
                , message: '',

                init() {
                    if (this.selectedEvent) {
                        this.fetchSessions();
                    }
                },

                fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/get-presences-history', {
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
                                this.sessions = data.sessions; // Store sessions data
                                this.attendance = data.attendance; // Store attendance data
                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.sessions = [];
                        this.attendance = {};
                    }
                },

                sortedAttendance() {
                    // Sort attendance by the index before rendering
                    return Object.values(this.attendance).sort((a, b) => a.index - b.index);
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
