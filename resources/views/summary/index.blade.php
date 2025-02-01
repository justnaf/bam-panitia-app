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
                <!-- Gender Grafik -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <h1 class="text-center font-bold text-lg">Grafik Peserta</h1>
                        <template x-if="!selectedEvent">
                            <p class="text-center">Silahkan Pilih Kegiatan</p>
                        </template>
                        <template x-if="selectedEvent">
                            <div>
                                <canvas id="graphPeserta"></canvas>
                                <div>
                                    <p class="font-bold">Laki - Laki: <span x-text="gender['Laki-laki']"></span></p>
                                    <p class="font-bold">Perempuan: <span x-text="gender['Perempuan']"></span></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Organization Grafik -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <h1 class="text-center font-bold text-lg">Grafik Pengalaman Organisasi</h1>
                        <template x-if="!selectedEvent">
                            <p class="text-center">Silahkan Pilih Kegiatan</p>
                        </template>
                        <template x-if="selectedEvent">
                            <div>
                                <canvas id="graphOrg"></canvas>
                                <div>
                                    <p class="font-bold">1 Organisasi: <span x-text="org['1 Organisasi']"></span></p>
                                    <p class="font-bold">2 Organisasi: <span x-text="org['2 Organisasi']"></span></p>
                                    <p class="font-bold">3 Organisasi: <span x-text="org['3 Organisasi']"></span></p>
                                    <p class="font-bold">4 Organisasi: <span x-text="org['4 Organisasi']"></span></p>
                                    <p class="font-bold">5+ Organisasi: <span x-text="org['5+ Organisasi']"></span></p>
                                </div>
                            </div>
                        </template>
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
                selectedEvent: ''
                , gender: {}
                , org: {},

                fetchSessions() {
                    if (this.selectedEvent) {
                        fetch('/eventSummary/getSummaryData', {
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
                                console.log(data); // Debugging log to see the full response
                                this.gender = data.gender; // Now you can directly use gender data
                                this.org = data.org; // Now you can directly use org data
                                this.createDoughnutChart(); // Create Gender Chart after data is fetched
                                this.createOrgChart(); // Create Organization Chart after data is fetched
                            })
                            .catch(error => console.error('Error fetching summary data:', error));

                    } else {
                        this.gender = [];
                        this.org = [];
                    }
                },


                // Create Doughnut chart for Gender
                createDoughnutChart() {
                    const ctx = document.getElementById('graphPeserta').getContext('2d');

                    // Destroy any existing chart to avoid reinitializing on each fetch
                    if (this.chart) {
                        this.chart.destroy();
                    }

                    // Unwrap Proxy object (if applicable) and handle the values
                    const male = this.gender['Laki-laki'] || 0;
                    const female = this.gender['Perempuan'] || 0;

                    // Create new chart
                    this.chart = new Chart(ctx, {
                        type: 'doughnut'
                        , data: {
                            labels: ['Laki-laki', 'Perempuan']
                            , datasets: [{
                                data: [male, female]
                                , backgroundColor: [
                                    'rgb(54, 162, 235)'
                                    , 'rgb(255, 99, 132)'
                                ]
                                , hoverOffset: 4
                            }]
                        }
                        , options: {
                            responsive: true
                        }
                    });
                },

                // Create Doughnut chart for Organization Count
                createOrgChart() {
                    const ctx = document.getElementById('graphOrg').getContext('2d');

                    // Destroy any existing chart to avoid reinitializing on each fetch
                    if (this.orgChart) {
                        this.orgChart.destroy();
                    }

                    // Unwrap Proxy object (if applicable) and handle the values
                    const org1 = this.org['1 Organisasi'] || 0;
                    const org2 = this.org['2 Organisasi'] || 0;
                    const org3 = this.org['3 Organisasi'] || 0;
                    const org4 = this.org['4 Organisasi'] || 0;
                    const org5Plus = this.org['5+ Organisasi'] || 0;

                    // Create new chart
                    this.orgChart = new Chart(ctx, {
                        type: 'doughnut'
                        , data: {
                            labels: ['1 Organisasi', '2 Organisasi', '3 Organisasi', '4 Organisasi', '5+ Organisasi']
                            , datasets: [{
                                data: [org1, org2, org3, org4, org5Plus]
                                , backgroundColor: [
                                    'rgb(75, 192, 192)'
                                    , 'rgb(153, 102, 255)'
                                    , 'rgb(255, 159, 64)'
                                    , 'rgb(255, 205, 86)'
                                    , 'rgb(201, 203, 207)'
                                ]
                                , hoverOffset: 4
                            }]
                        }
                        , options: {
                            responsive: true
                        }
                    });
                }
            }
        }

    </script>
    @endpush
</x-app-layout>
