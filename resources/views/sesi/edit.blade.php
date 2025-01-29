<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('sesi.index')}}">Sesi Management</a> > <span>Edit</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <a href="{{route('sesi.index')}}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-extrabold text-2xl mb-2">Form Edit Sesi</h1>
                    <p class="text-center italic text-slate-500 mb-2">Harap mengisikan seluruh kolom dengan tanda <span class="text-red-600 font-extrabold">*</span>.</p>
                    <form method="POST" action="{{route('sesi.update',$sesi->id)}}" class="max-w-xl mx-auto" x-data='sesiForm' x-ref='seForm' enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="text" name="event_id" value="{{$sesi->event_id}}" hidden>
                        <x-input-error :messages="$errors->get('event_id')" class="mt-2" />
                        <div class="grid grid-flow-row grid-cols-2 gap-4">
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Nama Sesi<span class="text-red-600 font-extrabold">*</span>
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Materi 1 : Al Islam Kemuhammadiyahan" type="text" name="name" id="name" value="{{$sesi->name}}" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="speaker">
                                    Pembicara<span class="text-red-600 font-extrabold">*</span>
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Rofiul Maruf" type="text" name="speaker" id="speaker" value="{{$sesi->speaker}}" />
                                <x-input-error :messages="$errors->get('speaker')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="room">
                                    Nama Ruangan<span class="text-red-600 font-extrabold">*</span>
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Auditorium" type="text" name="room" id="room" value="{{$sesi->room}}" />
                                <x-input-error :messages="$errors->get('room')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="time">
                                    Waktu<span class="text-red-600 font-extrabold">*</span>
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="Day 1, 13:00 - 15:00" type="text" name="time" id="time" value="{{$sesi->time}}" />
                                <x-input-error :messages="$errors->get('time')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="time">
                                    Jenis Sesi<span class="text-red-600 font-extrabold">*</span>
                                </label>
                                <div class="grid grid-flow-col gap-2">
                                    <div class="flex items-center">
                                        <input id="default-radio-1" type="radio" value="diskusi" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesi->type == 'diskusi' ? 'checked' : '' }}>
                                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Diskusi</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="default-radio-2" type="radio" value="materi" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesi->type == 'materi' ? 'checked' : '' }}>
                                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Materi</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="default-radio-3" type="radio" value="lain-lain" name="type" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesi->type == 'lain-lain' ? 'checked' : '' }}>
                                        <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Lain-lain</label>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="time">
                                    Penilaian<span class="text-red-600 font-extrabold">*</span>
                                </label>
                                <div class="grid grid-flow-col gap-2">
                                    <div class="flex items-center">
                                        <input id="grade-radio-1" type="radio" value="1" name="grade" class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 focus:ring-pink-500 dark:focus:ring-pink-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesi->grade == 1 ? 'checked' : '' }}>
                                        <label for="grade-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Enable</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="grade-radio-2" type="radio" value="0" name="grade" class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 focus:ring-pink-500 dark:focus:ring-pink-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesi->grade == 0 ? 'checked' : '' }}>
                                        <label for="grade-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Disable</label>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('grade')" class="mt-2" />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="time">
                                    CV
                                </label>
                                <div x-data="CVUploadHandler()" class="flex items-center justify-center w-full">
                                    <template x-if="!cv">
                                        <label for="dropzone-file-cv" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPG or JPEG (MAX. 800x400px)</p>
                                            </div>
                                        </label>
                                    </template>
                                    <input id="dropzone-file-cv" type="file" hidden @change="handleFileUpload" name="cv" accept="application/pdf,image/jpeg, image/jpg" />

                                    <!-- Preview Section -->
                                    <template x-if="cv">
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Selected file:</p>
                                            <p class="text-gray-800 dark:text-white font-semibold" x-text="cv.name"></p>
                                            <button @click="removeFile" class="mt-2 text-red-500 hover:text-white border border-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                                                Remove File
                                            </button>
                                        </div>
                                    </template>
                                </div>

                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="time">
                                    Materi
                                </label>
                                <div x-data="MateriUploadHandler()" class="flex items-center justify-center w-full">
                                    <template x-if="!materi">
                                        <label for="dropzone-file-materi" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPG or JPEG (MAX. 800x400px)</p>
                                            </div>
                                        </label>
                                    </template>
                                    <input id="dropzone-file-materi" hidden type="file" @change="handleFileUpload" name="materi" accept="application/pdf,image/jpeg, image/jpg" />
                                    <!-- Preview Section -->
                                    <template x-if="materi">
                                        <div class="mt-1">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Selected file:</p>
                                            <p class="text-gray-800 dark:text-white font-semibold" x-text="materi.name"></p>
                                            <button @click="removeFile" class="mt-2 text-red-500 hover:text-white border border-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                                                Remove File
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="px-1 mt-3">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmSimpan"><span class="font-extrabold">Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function CVUploadHandler() {
            return {
                cv: null
                , handleFileUpload(event) {
                    this.cv = event.target.files[0];
                    // Set file pada input hidden
                    const inputElement = document.getElementById('dropzone-file-cv');
                    inputElement.files = event.target.files;
                }
                , removeFile() {
                    this.cv = null;
                    const inputElement = document.getElementById('dropzone-file-cv');
                    inputElement.value = ''; // Reset file input
                }
            };
        }


        function MateriUploadHandler() {
            return {
                materi: null
                , handleFileUpload(event) {
                    this.materi = event.target.files[0];
                    // Set file pada input hidden
                    const inputElement = document.getElementById('dropzone-file-materi');
                    inputElement.files = event.target.files;
                }
                , removeFile() {
                    this.materi = null;
                    const inputElement = document.getElementById('dropzone-file-materi');
                    inputElement.value = ''; // Reset file input
                }
            };
        }


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
