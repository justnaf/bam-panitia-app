<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grade Management') }}
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

                <a :href="'{{ route('grades.generate','') }}/'+selectedEvent" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Generate Penilaian
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
                                    <th class="px-2 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody x-data="{ modelHasGrade: [] }" x-init="fetchSessions()">
                                <template x-for="(grade, index) in grades" :key="grade.id">
                                    <tr class="border-b">
                                        <td class="px-2 py-3" x-text="index + 1"></td>
                                        <td class="px-2 py-3" x-text="grade.number"></td>
                                        <td class="px-2 py-3" x-text="grade.user.username"></td>
                                        <td class="px-2 py-3" x-text="grade.user.data_diri.name"></td>
                                        <td>
                                            <a :href="'grades/'+grade.user.code+'/'+grade.event_id+'/edit'" class="hover:text-emerald-500" title="Edit Penilaian"><i class="fas fa-pencil-alt"></i></a>
                                            <form method="POST" :action="'{{ route('grades.delete', '') }}/' + grade.user_id" x-data="deleteForm" x-ref="form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="hover:text-red-500" @click="confirmDelete" title="Hapus Semua Nilai User">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                </template>
                                <template x-if="grades.length === 0">
                                    <tr>
                                        <td colspan="5" class="text-center py-3">Tidak ada data penilaian</td>
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
                , grades: [],

                init() {
                    if (this.selectedEvent) {
                        this.fetchSessions();
                    }
                },

                fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/grades/getpeserta', {
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
                                this.grades = data; // Simpan data langsung ke sessions
                                console.log(this.grades);
                            })
                            .catch(error => console.error('Error fetching grades:', error));
                    } else {
                        this.grades = []; // Reset data jika tidak ada event yang dipilih
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
