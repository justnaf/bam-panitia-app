<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kamar') }}
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
                <a :href="'{{ route('restroom.create') }}?event_id=' + selectedEvent" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    <input type="text" name="event_id" hidden x-model="selectedEvent">
                    Tambah Ruang Istirahat
                </a>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">#</th>
                                    <th class="px-2 py-3">Nama Kamar</th>
                                    <th class="px-2 py-3">Kapasitas</th>
                                    <th class="px-2 py-3">Jenis Kelamin</th>
                                    <th class="px-2 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="selectedEvent && Array.isArray(data) && data.length > 0">
                                    <template x-for="(room, index) in data" :key="room.id">
                                        <tr>
                                            <td class="p-3" x-text="index + 1"></td>
                                            <td class="p-3" x-text="room.name"></td>
                                            <td class="p-3" x-text="room.capacity"></td>
                                            <td class="p-3" x-text="room.gender"></td>
                                            <td class="p-3">
                                                <a :href="'restroom/'+ room.id+'/edit'" class="hover:text-orange-500">
                                                    <i class="fas fa-pencil-alt" title="Edit"></i>
                                                </a>
                                                <form method="POST" :action="'restroom/' + room.id" x-data="deleteForm" x-ref="form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="hover:text-red-500" @click="confirmDelete">
                                                        <i class="fas fa-trash" title="Delete"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="!selectedEvent">
                                    <tr>
                                        <td colspan="5" class="text-center p-3">Pilih Kegiatan</td>
                                    </tr>
                                </template>
                                <template x-if="selectedEvent && Array.isArray(data) && data.length === 0">
                                    <tr>
                                        <td colspan="5" class="text-center p-3">Tidak ada data</td>
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
        function eventHandler(initialId) {
            return {
                selectedEvent: initialId
                , data: [],

                init() {
                    if (this.selectedEvent) {
                        this.fetchSessions();
                    }
                }
                , fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/restroom', {
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
                            .then(response => {
                                this.data = response.data || [];
                                console.log(this.data);

                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.data = [];
                    }
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
