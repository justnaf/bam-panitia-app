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
                        <h2 class="text-center text-sm">{{$user->dataDiri->name}}</h2>
                        <h3 class="text-center font-bold text-sm">{{$user->username}}</h3>
                        <div class="max-w-lg mx-auto">
                            <h1 class="text-center font-bold">{{$sesis[0]->sesi->name}}</h1>
                            <form method="POST" action="{{route('grades.update',['eventId'=>$sesis[0]->event_id,'userId'=>$user->code,'gradeId'=>$sesis[0]->id])}}" class="mt-3 text-center">
                                @csrf
                                @method('PUT')
                                <div class="w-full px-1 mb-4">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Keaktifan (Presentasi, Bertanya, Menjawab, Mengikuti Diskusi)
                                    </label>
                                    <div class="grid grid-flow-col gap-2">
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-1" type="radio" value="1" name="poin_1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_1 == '1' ? 'checked' : '' }}>
                                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">1</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-2" type="radio" value="2" name="poin_1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_1 == '2' ? 'checked' : '' }}>
                                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">2</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-3" type="radio" value="3" name="poin_1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_1 == '3' ? 'checked' : '' }}>
                                            <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">3</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-4" type="radio" value="4" name="poin_1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_1 == '4' ? 'checked' : '' }}>
                                            <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">4</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-5" type="radio" value="5" name="poin_1" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_1 == '5' ? 'checked' : '' }}>
                                            <label for="default-radio-5" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">5</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-1  mb-4">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Kedisiplinan (Taat Peraturan, Tepat Waktu, Keluar Ruangan)
                                    </label>
                                    <div class="grid grid-flow-col gap-2">
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-1" type="radio" value="1" name="poin_2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_2 == '1' ? 'checked' : '' }}>
                                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">1</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-2" type="radio" value="2" name="poin_2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_2 == '2' ? 'checked' : '' }}>
                                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">2</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-3" type="radio" value="3" name="poin_2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_2 == '3' ? 'checked' : '' }}>
                                            <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">3</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-4" type="radio" value="4" name="poin_2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_2 == '4' ? 'checked' : '' }}>
                                            <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">4</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-5" type="radio" value="5" name="poin_2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_2 == '5' ? 'checked' : '' }}>
                                            <label for="default-radio-5" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">5</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-1  mb-4">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Sikap dan Etika (Berpakaian, Perilaku, Ucapan, Memperhatikan Materi)
                                    </label>
                                    <div class="grid grid-flow-col gap-2">
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-1" type="radio" value="1" name="poin_3" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_3 == '1' ? 'checked' : '' }}>
                                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">1</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-2" type="radio" value="2" name="poin_3" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_3 == '2' ? 'checked' : '' }}>
                                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">2</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-3" type="radio" value="3" name="poin_3" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_3 == '3' ? 'checked' : '' }}>
                                            <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">3</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-4" type="radio" value="4" name="poin_3" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_3 == '4' ? 'checked' : '' }}>
                                            <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">4</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-5" type="radio" value="5" name="poin_3" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_3 == '5' ? 'checked' : '' }}>
                                            <label for="default-radio-5" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">5</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full px-1 mb-4">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                        Antusiasme (Interaksi dengan Pemateri, Responsi dalam diskusi, Fokus dalam forum)
                                    </label>
                                    <div class="grid grid-flow-col gap-2">
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-1" type="radio" value="1" name="poin_4" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_4 == '1' ? 'checked' : '' }}>
                                            <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">1</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-2" type="radio" value="2" name="poin_4" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_4 == '2' ? 'checked' : '' }}>
                                            <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">2</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-3" type="radio" value="3" name="poin_4" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_4 == '3' ? 'checked' : '' }}>
                                            <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">3</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-4" type="radio" value="4" name="poin_4" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_4 == '4' ? 'checked' : '' }}>
                                            <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">4</label>
                                        </div>
                                        <div class="flex items-center justify-center">
                                            <input id="default-radio-5" type="radio" value="5" name="poin_4" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" {{ $sesis[0]->poin_4 == '5' ? 'checked' : '' }}>
                                            <label for="default-radio-5" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">5</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="py-4">
                                    <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><span class="font-extrabold">Simpan</span></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
