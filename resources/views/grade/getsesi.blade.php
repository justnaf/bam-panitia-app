<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{route('grades.index')}}">Grades Management</a> > <span>Edit</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <div class="mx-auto">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                    <div class="p-6 text-gray-900 overflow-x-auto ">
                        <h1 class="text-center font-extrabold text-xl mb-4">Edit Penilaian</h1>
                        <h2 class="text-center text-sm">{{$user[0]->dataDiri->name}}</h2>
                        <h3 class="text-center font-bold text-sm">{{$user[0]->username}}</h3>
                        <div class="max-w-lg mx-auto">
                            <div class="w-full px-1" x-data="sesiHandler()">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                    Pilih Sesi
                                </label>
                                <select x-model="selectedSesi" class=" block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="name" id="name">
                                    <option value="" selected disabled>-- Pilih sesi --</option>
                                    @foreach ($sesis as $sesi)
                                    <option value="{{$sesi->id}}">{{$sesi->name}}</option>
                                    @endforeach
                                </select>
                                <div class="py-4">
                                    <template x-if="selectedSesi">
                                        <a :href="`${selectedSesi}/edit`" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span class="font-extrabold">Edit</span></a>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function sesiHandler() {
            return {
                selectedSesi: ''
            , }
        }

    </script>
    @endpush
</x-app-layout>
