<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <a href="{{ route('events.create') }}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                Tambah Kegiatan
            </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <div x-data="tableComponent()">
                        <div class="flex justify-between mx-auto">
                            <div class="mb-4">
                                <select id="entriesPerPage" x-model="perPage" class="border rounded py-2 px-6">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                        </div>
                        <!-- Table -->
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">#</th>
                                    <th class="px-2 py-3">Nama Kegiatan</th>
                                    <th class="px-2 py-3">Mulai</th>
                                    <th class="px-2 py-3">Selesai</th>
                                    <th class="px-2 py-3">Lokasi</th>
                                    <th class="px-2 py-3">Penyelenggara</th>
                                    <th class="px-2 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Rows -->
                                <template x-for="event in paginatedEvents" :key="event.id">
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-2 py-4">
                                            <div x-data="{
                                                status: event.status,
                                                statusMap: {
                                                    draft: 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                    submission: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                    preparation: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                    registration: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                    'on-going': 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-300',
                                                    done: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300'
                                                },
                                                statusText: {
                                                    draft: 'Draft',
                                                    submission: 'Submission',
                                                    preparation: 'Persiapan',
                                                    registration: 'Registrasi',
                                                    'on-going': 'Sedang Berlangsung',
                                                    done: 'Selesai'
                                                }
                                            }">
                                                <span :class="statusMap[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300'" class="text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
                                                    <span x-text="statusText[status] || 'Status Tidak Diketahui'"></span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-2 py-4" x-text="event.name"></td>
                                        <td class="px-2 py-4" x-text="event.start_date"></td>
                                        <td class="px-2 py-4" x-text="event.end_date"></td>
                                        <td class="px-2 py-4" x-text="event.location"></td>
                                        <td class="px-2 py-4" x-text="event.institution"></td>
                                        <td class="px-2 py-4 flex space-x-2 items-center">
                                            <a :href="'/events/'+ event.id" class="hover:text-green-500">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a :href="'/events/'+ event.id+'/edit/'" class="hover:text-orange-500">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <template x-if="event.status == 'draft'">
                                                <div class="flex space-x-2">
                                                    <form method="POST" :action="'/events/' + event.id" x-data="deleteForm" x-ref="form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="hover:text-red-500" @click="confirmDelete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" :action="'/submission-event/' + event.id">
                                                        @csrf
                                                        <button type="submit" class="text-purple-500">
                                                            <i class="fas fa-file-upload"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </template>
                                        </td>
                                    </tr>
                                </template>

                                <!-- No Data -->
                                <template x-if="filteredEvents.length === 0">
                                    <tr>
                                        <td colspan="7" class="text-center px-6 py-4">Tidak ada data yang tersedia</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="mt-4 flex justify-between items-center">
                            <button @click="prevPage" :disabled="page === 1" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Previous</button>
                            <div class="flex space-x-2">
                                <template x-for="pageNumber in Array.from({ length: totalPages }, (_, i) => i + 1)" :key="pageNumber">
                                    <button @click="goToPage(pageNumber)" :class="{'bg-blue-500 text-white': page === pageNumber, 'bg-gray-200': page !== pageNumber}" class="px-4 py-2 rounded-md">
                                        <span x-text="pageNumber"></span>
                                    </button>
                                </template>
                            </div>
                            <button @click="nextPage" :disabled="page === totalPages" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function tableComponent() {
            return {
                events: @json($events)
                , page: 1
                , perPage: 5
                , get filteredEvents() {
                    return this.events;
                }
                , get paginatedEvents() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filteredEvents.slice(start, start + this.perPage);
                }
                , get totalPages() {
                    return Math.ceil(this.filteredEvents.length / this.perPage);
                }
                , nextPage() {
                    if (this.page < this.totalPages) this.page++;
                }
                , prevPage() {
                    if (this.page > 1) this.page--;
                }
                , goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) this.page = page;
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
