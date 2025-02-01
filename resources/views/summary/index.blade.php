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

                <!-- Gender Chart -->
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

                <!-- Organization Chart -->
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

                <!-- Karya Tulis Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <h1 class="text-center font-bold text-lg">Grafik Karya Tulis</h1>
                        <template x-if="!selectedEvent">
                            <p class="text-center">Silahkan Pilih Kegiatan</p>
                        </template>
                        <template x-if="selectedEvent">
                            <div>
                                <canvas id="graphPaper"></canvas>
                                <div>
                                    <p class="font-bold">1 Karya Tulis: <span x-text="paper['1 Paper']"></span></p>
                                    <p class="font-bold">2 Karya Tulis: <span x-text="paper['2 Paper']"></span></p>
                                    <p class="font-bold">3 Karya Tulis: <span x-text="paper['3 Paper']"></span></p>
                                    <p class="font-bold">4 Karya Tulis: <span x-text="paper['4 Paper']"></span></p>
                                    <p class="font-bold">5+ Karya Tulis: <span x-text="paper['5+ Paper']"></span></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Minat Baca Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 text-gray-900">
                        <h1 class="text-center font-bold text-lg">Grafik Minat Baca</h1>
                        <template x-if="!selectedEvent">
                            <p class="text-center">Silahkan Pilih Kegiatan</p>
                        </template>
                        <template x-if="selectedEvent">
                            <div>
                                <canvas id="graphReadIn"></canvas>
                                <div>
                                    <template x-for="[category, count] in Object.entries(readin)">
                                        <p class="font-bold" x-text="`${category}: ${count}`"></p>
                                    </template>
                                </div>
                            </div>
                        </template>
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
                , org: {}
                , paper: {}
                , readin: {},

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
                                console.log(data);
                                this.gender = data.gender;
                                this.org = data.org;
                                this.paper = data.paper;
                                this.readin = data.readIn;
                                this.createDoughnutChart();
                                this.createOrgChart();
                                this.createPaperChart();
                                this.createReadInChart();
                            })
                            .catch(error => console.error('Error fetching summary data:', error));

                    } else {
                        this.gender = [];
                        this.org = [];
                        this.paper = [];
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

                    if (this.orgChart) {
                        this.orgChart.destroy();
                    }

                    const org1 = this.org['1 Organisasi'] || 0;
                    const org2 = this.org['2 Organisasi'] || 0;
                    const org3 = this.org['3 Organisasi'] || 0;
                    const org4 = this.org['4 Organisasi'] || 0;
                    const org5Plus = this.org['5+ Organisasi'] || 0;

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

                // Paper Chart
                , createPaperChart() {
                    const ctx = document.getElementById('graphPaper').getContext('2d');

                    // Destroy any existing chart to avoid reinitializing on each fetch
                    if (this.paperChart) {
                        this.paperChart.destroy();
                    }

                    // Unwrap Proxy object (if applicable) and handle the values
                    const paper1 = this.paper['1 Paper'] || 0;
                    const paper2 = this.paper['2 Paper'] || 0;
                    const paper3 = this.paper['3 Paper'] || 0;
                    const paper4 = this.paper['4 Paper'] || 0;
                    const paper5Plus = this.paper['5+ Paper'] || 0;

                    // Create new chart
                    this.paperChart = new Chart(ctx, {
                        type: 'doughnut'
                        , data: {
                            labels: ['1 Karya Tulis', '2 Karya Tulis', '3 Karya Tulis', '4 Karya Tulis', '5+ Karya Tulis']
                            , datasets: [{
                                data: [paper1, paper2, paper3, paper4, paper5Plus]
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

                // Read Interest (Minat Baca) Chart
                , createReadInChart() {
                    const ctx = document.getElementById('graphReadIn').getContext('2d');

                    // Destroy any existing chart
                    if (this.readInChart) {
                        this.readInChart.destroy();
                    }

                    // Extract categories and counts
                    const labels = Object.keys(this.readin);
                    const data = Object.values(this.readin);

                    // Define colors dynamically
                    const colors = [
                        'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)'
                        , 'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)'
                        , 'rgb(201, 203, 207)', 'rgb(100, 149, 237)', 'rgb(144, 238, 144)', 'rgb(255, 182, 193)'
                    ];

                    // Create a new chart
                    this.readInChart = new Chart(ctx, {
                        type: 'doughnut'
                        , data: {
                            labels: labels
                            , datasets: [{
                                data: data
                                , backgroundColor: colors.slice(0, labels.length), // Assign colors based on labels
                                hoverOffset: 4
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
