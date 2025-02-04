<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Penyakit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')

            <div class="mx-auto" x-data="eventHandler()">
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

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">#</th>
                                    <th class="px-2 py-3">NPM</th>
                                    <th class="px-2 py-3">Nama</th>
                                    <th class="px-2 py-3">Penyakit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="selectedEvent && data.users.length > 0">
                                    <template x-for="(user, index) in data.users" :key="user.id">
                                        <tr>
                                            <td class="p-3" x-text="index + 1"></td>
                                            <td class="p-3" x-text="user.username"></td>
                                            <td class="p-3" x-text="user.data_diri.name"></td>
                                            <td class="p-3">
                                                <template x-for="disease in user.diseases">
                                                    <template x-if="disease.common == 'etc'">
                                                        <p x-text="disease.etc"></p>
                                                    </template>
                                                    <template x-if="!disease.common == 'etc'">
                                                        <p x-text="disease.common"></p>
                                                    </template>
                                                </template>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="!selectedEvent">
                                    <tr>
                                        <td colspan="4" class="text-center p-3">Pilih Kegiatan</td>
                                    </tr>
                                </template>
                                <template x-if="selectedEvent && data.users.length === 0">
                                    <tr>
                                        <td colspan="4" class="text-center p-3">Tidak ada data</td>
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
        function eventHandler() {
            return {
                selectedEvent: ''
                , data: {
                    users: []
                },

                fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/health/disease', {
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
                                this.data = data;
                                console.log(this.data);

                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.data = [];
                    }
                }
            }
        }

    </script>
    @endpush
</x-app-layout>
