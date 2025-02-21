<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presensi Kajian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-center font-bold text-2xl mb-3">Presensi Kajian</h1>
                    <div class="max-w-lg mx-auto" x-data="{selectedEvent : null}">
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div class="w-full px-1 col-span-2">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="status">
                                    Kajian
                                </label>
                                <select x-model="selectedEvent" class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="status" id="status" required>
                                    <option selected>-- Silahkan Pilih Kajian--</option>
                                    @foreach ($kajian as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="px-1" x-show="selectedEvent">
                            <a :href="'majelis-presecense/'+selectedEvent" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span class="font-extrabold">Buka Scanner</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
