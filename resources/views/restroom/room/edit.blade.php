<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('restroom.index')}}">Data Kamar</a> > <span>Tambah</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <a href="{{route('restroom.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-extrabold text-2xl mb-2">Form Edit Ruang Istirahat</h1>
                    <form method="POST" action="{{route('restroom.update',$roomId->id)}}" class="max-w-xl mx-auto" x-data='sesiForm' x-ref='seForm' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-flow-row grid-cols-2 gap-4">
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Nama Ruang
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Ruangan 103" type="text" name="name" id="name" value="{{$roomId->name}}" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="capacity">
                                    Kapasitas
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="300" type="number" name="capacity" id="capacity" value="{{$roomId->capacity}}" />
                                <x-input-error :messages="$errors->get('speaker')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="time">
                                    Gender
                                </label>
                                <div class="grid grid-flow-col gap-2">
                                    <div class="flex items-center">
                                        <input id="grade-radio-1" type="radio" value="Laki-laki" name="gender" class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 focus:ring-pink-500 dark:focus:ring-pink-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $roomId->gender == 'Laki-laki' ? 'checked' : '' }}>
                                        <label for="grade-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Laki - Laki</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="grade-radio-2" type="radio" value="Perempuan" name="gender" class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 focus:ring-pink-500 dark:focus:ring-pink-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $roomId->gender == 'Perempuan' ? 'checked' : '' }}>
                                        <label for="grade-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Perempuan</label>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                            </div>
                        </div>
                        <div class="px-1 mt-3">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmSimpan"><span class="font-extrabold">Simpan</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function sesiForm() {
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
                            this.$refs.seForm.submit();
                        }
                    });
                }
            , };
        }

    </script>
    @endpush
</x-app-layout>
