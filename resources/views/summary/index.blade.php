<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Event Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="eventSummary()">
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
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <h1 class="text-center font-bold text-lg">Grafik Peserta</h1>
                        <template x-if="!selectedEvent">
                            <p class="text-center">Silahkan Pilih Kegiatan</p>
                        </template>
                        <template x-if="selectedEvent">
                            <div>
                                <canvas id="acquisitions"></canvas>
                                <div>
                                    <p>Laki - Laki :</p>
                                    <p>Perempuan :</p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <h1 class="text-center font-bold text-lg">Grafik Pengalaman Organisasi</h1>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <h1 class="text-center font-bold text-lg">Grafik Minat Baca</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function eventSummary() {
            return {
                selectedEvent: '',


                fetchPeserta() {
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
                    }
                }

            }

        }
        document.addEventListener("DOMContentLoaded", async function() {

            // Wait until Chart.js is fully loaded
            while (!window.Chart) {
                await new Promise(resolve => setTimeout(resolve, 100));
            }

            console.log("Chart.js is now available!");

            const ctx = document.getElementById('acquisitions').getContext('2d');

            new window.Chart(ctx, {
                type: 'doughnut'
                , data: {
                    labels: [
                        'Laki-laki'
                        , 'Perepmuan'
                    ]
                    , datasets: [{
                        data: [300, 50]
                        , backgroundColor: [
                            'rgb(255, 99, 132)'
                            , 'rgb(54, 162, 235)'
                        ]
                        , hoverOffset: 4
                    }]
                }
                , options: {
                    responsive: true
                }
            });
        });

    </script>
    @endpush
</x-app-layout>
