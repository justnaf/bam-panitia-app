<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div x-data="eventSelection()">
                        <div class="w-full px-1 mb-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                Nama Kegiatan
                            </label>
                            <select x-model="selectedEvent" class="w-full px-2 py-1 border rounded-md" name="event_id">
                                <option value="">Pilih Kegiatan</option>
                                <template x-for="event in events" :key="event.id">
                                    <option :value="event.id" x-text="event.name"></option>
                                </template>
                            </select>
                        </div>
                        <div class="w-full px-1">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                Sesi
                            </label>
                            <select x-ref="sesi" x-model="selectedSesi" :disabled="!selectedEvent" class="w-full px-2 py-1 border rounded-md" name="sesi_id">
                                <option value="">Pilih Sesi</option>
                                <template x-for="sesi in getSesies(selectedEvent)" :key="sesi.id">
                                    <option :value="sesi.id" x-text="sesi.name"></option>
                                </template>
                            </select>
                        </div>
                        <a x-show="selectedEvent && selectedSesi" :href="'presences/' + selectedEvent + '/' + selectedSesi" class="mt-4 inline-block px-4 py-2 bg-emerald-500 text-white rounded-md">Buka Scanner</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function eventSelection() {
            return {
                selectedEvent: null
                , selectedSesi: null
                , events: @json($events), // Pass your events data from Laravel to Alpine.js

                getSesies(eventId) {
                    const selectedEventId = Number(eventId);
                    const event = this.events.find(e => e.id === selectedEventId);
                    return event ? event.sesi : [];
                }
            };
        }

    </script>

    @endpush
</x-app-layout>
