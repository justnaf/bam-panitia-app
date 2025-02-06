<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('restroom.indexDistri')}}">Pembagian Kamar</a> > <span>Edit</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <a href="{{route('restroom.indexDistri')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-extrabold text-2xl mb-4">Form Bagi Kamar</h1>
                    <table class="w-8/12 mx-auto text-sm text-left text-gray-500 border border-gray-200 mb-4">
                        <tr>
                            <td class="px-2 py-2 bg-gray-500 text-white">Nama Ruangan</td>
                            <td class="px-2 py-2">
                                <h2>{{$roomId->name}}</h2>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 bg-gray-500 text-white">Kapasitas</td>
                            <td class="px-2 py-2">
                                <h2>{{$roomId->capacity}}</h2>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-2 py-2 bg-gray-500 text-white">Jenis Kelamin</td>
                            <td class="px-2 py-2">
                                <h2>{{$roomId->gender}}</h2>
                            </td>
                        </tr>
                    </table>
                    <div class="mb-3" x-data="eventHandler({{ $roomId->event_id ?? 'null'}}, '{{ $roomId->gender ?? 'null'}}', '{{ $roomId->id ?? 'null'}}')">
                        <h1 class="text-center font-extrabold text-lg mb-2">Data Peserta Dikamar Ini</h1>
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">#</th>
                                    <th class="px-2 py-3">NPM</th>
                                    <th class="px-2 py-3">Nama</th>
                                    <th class="px-2 py-3">Gender</th>
                                    <th class="px-2 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="selectedEvent && Array.isArray(joins) && joins.length > 0">
                                    <template x-for="(join, index) in joins" :key="join.user.id">
                                        <tr>
                                            <td class="p-3" x-text="index + 1"></td>
                                            <td class="p-3" x-text="join.user.username"></td>
                                            <td class="p-3" x-text="join.user.data_diri.name"></td>
                                            <td class="p-3" x-text="join.user.data_diri.gender"></td>
                                            <td class="p-3">
                                                <form method="POST" :action="join.id" x-data="deleteForm" x-ref="delform">
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
                                <template x-if="selectedEvent && Array.isArray(joins) && joins.length === 0">
                                    <tr>
                                        <td colspan="5" class="text-center p-3">Belum Ada Peserta {{$roomId->gender}} Di Kamar Ini</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <div class="mb-3" x-data="eventHandler({{ $roomId->event_id ?? 'null'}}, '{{ $roomId->gender ?? 'null'}}', '{{ $roomId->id ?? 'null'}}')">
                        <h1 class="text-center font-extrabold text-lg mb-2">Peserta Yang Belum Dapat Kamar</h1>
                        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th class="px-2 py-3">#</th>
                                    <th class="px-2 py-3">NPM</th>
                                    <th class="px-2 py-3">Nama</th>
                                    <th class="px-2 py-3">Gender</th>
                                    <th class="px-2 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-if="selectedEvent && Array.isArray(unjoins) && unjoins.length > 0">
                                    <template x-for="(unjoin, index) in unjoins" :key="unjoin.user.id">
                                        <tr>
                                            <td class="p-3" x-text="index + 1"></td>
                                            <td class="p-3" x-text="unjoin.user.username"></td>
                                            <td class="p-3" x-text="unjoin.user.data_diri.name"></td>
                                            <td class="p-3" x-text="unjoin.user.data_diri.gender"></td>
                                            <td class="p-3">
                                                <form method="POST" action="{{route('restroom.storeDistri')}}" x-data="addForm" x-ref="form">
                                                    @csrf
                                                    <input type="text" name="event_id" x-bind:value="unjoin.event_id" hidden>
                                                    <input type="text" name="user_id" x-bind:value="unjoin.user_id" hidden>
                                                    <input type="text" name="rest_room_id" value="{{$roomId->id}}" hidden>
                                                    <button type="button" class="hover:text-emerald-500" @click="confirm">
                                                        <i class="fas fa-user-plus" title="Add"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                                <template x-if="selectedEvent && Array.isArray(unjoins) && unjoins.length === 0">
                                    <tr>
                                        <td colspan="5" class="text-center p-3">Peserta {{$roomId->gender}} Sudah Memiliki Kamar Semua</td>
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
        function eventHandler(initialId, gender, id) {
            return {
                selectedEvent: initialId
                , roomGender: gender
                , roomId: id
                , unjoins: []
                , joins: [],

                init() {
                    console.log(this.roomId);
                    if (this.selectedEvent) {
                        this.fetchUnjoin();
                        this.fetchJoin();
                    }
                }
                , fetchUnjoin() {
                    if (this.selectedEvent) {
                        fetch('/restroom-distribute/get-unjoin', {
                                method: 'POST'
                                , headers: {
                                    'Content-Type': 'application/json'
                                    , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                                , body: JSON.stringify({
                                    event_id: this.selectedEvent
                                    , gender: this.roomGender
                                })
                            })
                            .then(response => response.json())
                            .then(response => {
                                this.unjoins = response.data || [];
                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.unjoins = [];
                    }
                }
                , fetchJoin() {
                    if (this.selectedEvent) {
                        fetch('/restroom-distribute/get-join', {
                                method: 'POST'
                                , headers: {
                                    'Content-Type': 'application/json'
                                    , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                                , body: JSON.stringify({
                                    event_id: this.selectedEvent
                                    , rest_room_id: this.roomId
                                })
                            })
                            .then(response => response.json())
                            .then(response => {
                                this.joins = response.data || [];
                                console.log(this.joins);
                            })
                            .catch(error => console.error('Error fetching sessions:', error));
                    } else {
                        this.joins = [];
                    }
                }
            }
        }


        function addForm() {
            return {
                confirm() {
                    Swal.fire({
                        title: 'Are you sure?'
                        , text: "Yakin Ingin Manambahkan Data Ini!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Yes,Tambahkan'
                        , cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.$refs.form.submit();
                        }
                    });
                }
            };
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
                            this.$refs.delform.submit();
                        }
                    });
                }
            };
        }

    </script>
    @endpush
</x-app-layout>
