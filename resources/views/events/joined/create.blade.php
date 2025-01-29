<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('modelActiveEvents.index')}}">Joined Management</a> > <span>Buat</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <a href="{{route('modelActiveEvents.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-bold text-2xl mb-3">Form Force Joined</h1>
                    <form method="POST" action="{{route('modelActiveEvents.store')}}" class="max-w-lg mx-auto" x-data='forceForm' x-ref='eForm'>
                        @csrf
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="w-full px-1" x-data="dropdownSearch({ data: {{ $events->toJson() }}, label: 'name', value: 'id' })">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="event">
                                    Nama Kegiatan
                                </label>
                                <div class="relative">
                                    <input type="text" x-model="search" placeholder="Cari Kegiatan" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" @input="showList = !!search" />
                                    <ul x-show="showList && filteredData.length > 0" class="absolute z-10 bg-white border border-slate-300 rounded-md shadow-md mt-1 max-h-52 overflow-auto w-full" @click.away="showList = false">
                                        <template x-for="(item, index) in filteredData.slice(0, 5)" :key="item[value]">
                                            <li @click="selectItem(item)" class="cursor-pointer px-2 py-1 hover:bg-sky-100">
                                                <span x-text="item[label]"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <input type="hidden" name="event_id" x-model="selectedValue" />
                            </div>
                            <div class="w-full px-1" x-data="dropdownSearch({ data: {{ $users->toJson() }}, label: 'username', value: 'id' })">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="user">
                                    Peserta
                                </label>
                                <div class="relative">
                                    <input type="text" x-model="search" placeholder="Cari Peserta" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" @input="showList = !!search" />
                                    <ul x-show="showList && filteredData.length > 0" class="absolute z-10 bg-white border border-slate-300 rounded-md shadow-md mt-1 overflow-auto w-full max-h-52" @click.away="showList = false">
                                        <template x-for="(item, index) in filteredData.slice(0, 5)" :key="item[value]">
                                            <li @click="selectItem(item)" class="cursor-pointer px-2 py-1 hover:bg-sky-100">
                                                <span x-text="item[label]"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <input type="hidden" name="user_id" x-model="selectedValue" />
                            </div>
                            <div class="w-full px-1 col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="status">
                                    Status
                                </label>
                                <select class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" type="text" name="status" id="status" required>
                                    <option value="">Pilih</option>
                                    <option value="Peserta">Peserta</option>
                                    <option value="Panitia">Panitia</option>
                                    <option value="Instruktur">Instruktur</option>
                                </select>
                            </div>

                        </div>
                        <div class="px-1">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmSimpan"><span class="font-extrabold">Simpan</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function forceForm() {
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

        function dropdownSearch({
            data
            , label
            , value
        }) {
            return {
                data: data
                , label: label
                , value: value
                , search: ''
                , selectedValue: null
                , filteredData: []
                , showList: false, // Control visibility of the dropdown list

                init() {
                    this.filteredData = this.data;
                },

                get filteredData() {
                    if (!this.search) return this.data;
                    return this.data.filter(item =>
                        item[this.label].toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                selectItem(item) {
                    this.selectedValue = item[this.value];
                    this.search = item[this.label];
                    this.filteredData = [];
                    this.showList = false;
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
