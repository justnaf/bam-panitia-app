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
                    <div class="p-6 text-gray-900">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-4 py-2">Nama Mahasiswa</th>
                                    <template x-for="session in sessions" :key="session.id">
                                        <th class="px-4 py-2" x-text="session.name"></th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(index, student) in attendance" :key="studentId">
                                    <tr class="border-b">
                                        <td class="px-4 py-2" x-text="index + 1"></td>
                                        <td class="px-4 py-2" x-text="student.name"></td>
                                        <template x-for="(status, index) in student.sessions" :key="index">
                                            <td class="px-4 py-2" x-text="status"></td>
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
                , attendance: {},

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
                                console.log(this.attendance);

                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.sessions = [];
                        this.attendance = {};
                    }
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
