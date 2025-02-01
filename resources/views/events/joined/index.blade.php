<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Undang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <div class="mx-auto" x-data="eventHandler({{ $events->first()->id ?? 'null' }})" x-init="init()">
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <template x-for="(count, role) in roleCounts" :key="role">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-2">
                                <h1 class="text-lg font-bold" x-text="role"></h1>
                                <p class="text-lg" x-text="count"></p>
                            </div>
                        </div>
                    </template>
                </div>
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

                <a href="{{ route('modelActiveEvents.create') }}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Undang User
                </a>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">#</th>
                                    <th class="px-2 py-3">Nomor Dada</th>
                                    <th class="px-2 py-3">NPM</th>
                                    <th class="px-2 py-3">Nama</th>
                                    <th class="px-2 py-3">Role</th>
                                    <th class="px-2 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody x-data="{ modelActiveEvent: [] }" x-init="fetchSessions()">
                                <template x-for="(session, index) in sessions" :key="session.id">
                                    <tr class="border-b">
                                        <td class="px-2 py-3" x-text="index + 1"></td>
                                        <td class="px-2 py-3" x-text="session.number"></td>
                                        <td class="px-2 py-3" x-text="session.user.username"></td>
                                        <td class="px-2 py-3" x-text="session.user.data_diri.name"></td>
                                        <td class="px-2 py-3" x-text="session.user.roles[0].name"></td>
                                        <td>
                                            <a :href="'modelActiveEvents/'+session.id+'/edit'">Edit</a>
                                            <form method="POST" :action="'{{ route('modelActiveEvents.destroy', '') }}/' + session.id" x-data="deleteForm" x-ref="form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="hover:text-red-500" @click="confirmDelete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                </template>
                                <template x-if="sessions.length === 0">
                                    <tr>
                                        <td colspan="5" class="text-center py-3">Tidak ada data pengguna yang bergabung</td>
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
                , roleCounts: '',

                init() {
                    if (this.selectedEvent) {
                        this.fetchSessions();

                    }
                },

                fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/getuser-joined', {
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
                                // Store the role counts and session data
                                this.roleCounts = data.roleCounts;
                                this.sessions = data.modelActiveEvent;
                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.sessions = []; // Reset data if no event is selected
                        this.roleCounts = {}; // Reset role counts
                    }
                }

            , };
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
