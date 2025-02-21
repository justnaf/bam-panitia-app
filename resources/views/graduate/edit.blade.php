<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('grades.graduate.index')}}">Kelulusan</a> > <span>Edit</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-bold text-2xl mb-3">Form Edit Kelulusan</h1>
                    <form method="POST" action="{{route('grades.graduate.update',['graduateId'=>$graduate->id])}}" class="max-w-lg mx-auto" x-data='eventsForm' x-ref='eForm'>
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Nama Pengguna
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="BAM" type="text" name="name" id="name" value="{{$graduate->user->dataDiri->name}}" readonly required />
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="event">
                                    Nama Kegiatan
                                </label>
                                <input class="placeholder:italic placeholder:text-slate-400 block bg-gray-300 w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="BAM" type="text" name="event" id="event" value="{{$graduate->event->name}}" readonly required />
                            </div>
                            <div class="w-full px-1 col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="status">
                                    Status Kelulusan
                                </label>
                                <select class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="status" id="status" required>
                                    <option value="" disabled>-- Silahkan Pilih Kelulusan --</option>
                                    <option value="Lulus" {{ $graduate->status == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                    <option value="Lulus Bersyarat" {{ $graduate->status == 'Lulus Bersyarat' ? 'selected' : '' }}>Lulus Bersyarat</option>
                                    <option value="Tidak Lulus" {{ $graduate->status == 'Tidak Lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                                </select>
                            </div>
                            <div class="w-full px-1 col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="desc">
                                    Keterangan
                                </label>
                                <textarea class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" placeholder="BAM" type="text" name="desc" id="desc" required>{{$graduate->desc}}</textarea>
                            </div>
                        </div>
                        <div class="px-1">
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmSimpan"><span class="font-extrabold">Update</span></button>
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
