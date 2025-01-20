<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('events.index')}}">Events Management</a> > <span>Buat</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <a href="{{route('events.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-bold text-2xl mb-3">Form Buat Kegiatan</h1>
                    <form method="POST" action="{{route('events.store')}}" class="max-w-lg mx-auto" x-data='eventsForm' x-ref='eForm'>
                        @csrf
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Nama Kegiatan
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="BAM" type="text" name="name" id="name" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="institution">
                                    Penyelenggara
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="LP2SI UNIMMA" type="text" name="institution" id="institution" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location">
                                    Lokasi
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Auditorium UNIMMA" type="text" name="location" id="location" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="location_url">
                                    Link Gmaps Lokasi
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="https://" type="text" name="location_url" id="location_url" />
                            </div>
                            <div class="w-full px-1">
                                <div x-data="{ 
                                    open: false, 
                                    date: '', 
                                    formatDate(date) { 
                                        return new Date(date).toLocaleDateString('en-CA'); 
                                    },
                                    selectDate(event) {
                                        this.start_date = this.formatDate(event.target.value);
                                        this.open = false;
                                    }
                                }" class="relative">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Tanggal Mulai
                                    </label>
                                    <input type="text" name="start_date" x-model="start_date" @click="open = true" placeholder="Select date" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" readonly />

                                    <div x-show="open" @click.away="open = false" class="absolute bg-white border border-gray-300 rounded-md shadow-md mt-1 z-50 p-3">
                                        <input type="date" @change="selectDate" class="block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 sm:text-sm" />
                                    </div>
                                </div>
                            </div>
                            <div class="w-full px-1">
                                <div x-data="{ 
                                    open: false, 
                                    date: '', 
                                    formatDate(date) { 
                                        return new Date(date).toLocaleDateString('en-CA'); 
                                    },
                                    selectDate(event) {
                                        this.end_date = this.formatDate(event.target.value);
                                        this.open = false;
                                    }
                                }" class="relative">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Tanggal Selesai
                                    </label>
                                    <input type="text" name="end_date" x-model="end_date" @click="open = true" placeholder="Select date" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" readonly />

                                    <div x-show="open" @click.away="open = false" class="absolute bg-white border border-gray-300 rounded-md shadow-md mt-1 z-50 p-3">
                                        <input type="date" @change="selectDate" class="block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-sky-500 focus:border-sky-500 sm:text-sm" />
                                    </div>
                                </div>
                            </div>
                            <div class="w-full px-1 col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="max_person">
                                    Maksimum Peserta
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="9999" type="number" name="max_person" id="max_person" />
                            </div>
                        </div>
                        <div x-data="{ 
                            isChecked: false, 
                            user: { 
                                name: '{{ Auth::user()->dataDiri->name }}', 
                                email: '{{ Auth::user()->email }}' 
                            }, 
                            pic: '', 
                            email: '' 
                        }" class="grid grid-cols-2 gap-4">
                            <!-- Penanggung Jawab -->
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="pic">
                                    Penanggung Jawab
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none sm:text-sm" :class="isChecked ? 'bg-slate-300 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300' : 'bg-white focus:border-sky-500 focus:ring-sky-500 focus:ring-1 '" placeholder="Arief" type="text" name="pic" id="pic" x-model="isChecked ? user.name : pic" :readonly="isChecked" />
                            </div>

                            <!-- Email Penanggung Jawab -->
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                                    Email Penanggung Jawab
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:ring-1 sm:text-sm" :class="isChecked ? 'bg-slate-300 text-gray-500 focus:ring-0 focus:ring-gray-300 focus:border-gray-300' : 'bg-white focus:border-sky-500 focus:ring-sky-500 focus:ring-1 '" placeholder="ayip@unimma.ac.id" type="email" name="email" id="email" x-model="isChecked ? user.email : email" :readonly="isChecked" />
                            </div>

                            <!-- Checkbox -->
                            <div class="w-full px-1 flex space-x-2 col-span-2">
                                <input class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox" id="is_responsible" x-model="isChecked" />
                                <label for="is_responsible" class="block uppercase tracking-wide text-gray-700 text-xs font-bold">
                                    Saya sebagai penanggung jawab
                                </label>
                            </div>
                            <div class="px-1">
                                <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmSimpan"><span class="font-extrabold">Simpan</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function eventsForm() {
            return {
                confirmSimpan() {
                    Swal.fire({
                        title: 'Yakin?'
                        , text: "Sudah Yakin Dengan Data Yang Di Inputkan!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes'
                        , cancelButtonText: 'Cancel'
                    , }).then((result) => {
                        if (result.isConfirmed) {
                            // Explicitly reference the form element and submit it
                            this.$refs.eForm.submit();
                        }
                    });
                }
            , };
        }

    </script>
    @endpush
</x-app-layout>
