<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelulusan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="eventHandler()" x-init="init()">
            @include('includes.taost')
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
            <template x-if="selectedEvent && Array.isArray(graduate) && graduate.length === 0">
                <a :href="'{{ route('grades.graduate.generateall','') }}/'+selectedEvent" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Generate Kelulusan
                </a>
            </template>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                            <tr>
                                <th class="px-2 py-3">#</th>
                                <th class="px-2 py-3">NPM</th>
                                <th class="px-2 py-3">Nama</th>
                                <th class="px-2 py-3">Sebagai</th>
                                <th class="px-2 py-3">Status Kelulusan</th>
                                <th class="px-2 py-3">Keterangan</th>
                                <th class="px-2 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="selectedEvent && Array.isArray(graduate) && graduate.length > 0">
                                <template x-for="(item, index) in graduate" :key="item.id">
                                    <tr>
                                        <td class="p-3" x-text="index + 1"></td>
                                        <td class="p-3" x-text="item.user.username"></td>
                                        <td class="p-3" x-text="item.user.data_diri.name"></td>
                                        <td class="p-3" x-text="item.joined_as"></td>
                                        <td class="p-3" x-text="item.status"></td>
                                        <td class="p-3" x-text="item.desc"></td>
                                        <td class="p-3">
                                            <a :href="'graduate/'+item.id+'/edit'" class="hover:text-orange-500">
                                                <i class="fas fa-pencil-alt" title="Edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="!selectedEvent">
                                <tr>
                                    <td colspan="6" class="text-center p-3">Pilih Kegiatan</td>
                                </tr>
                            </template>
                            <template x-if="selectedEvent && Array.isArray(graduate) && graduate.length === 0">
                                <tr>
                                    <td colspan="6" class="text-center p-3">Tidak ada data</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function eventHandler() {
            return {
                graduate: {}
                , selectedEvent: ''

                , init() {
                    if (this.selectedEvent) {
                        this.fetchSessions();
                    }
                }
                , fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/graduate/get-data', {
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
                                this.graduate = data.history
                                console.log(this.graduate);
                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.graduate = {};
                    }
                }
            }
        }

    </script>
    @endpush
</x-app-layout>
