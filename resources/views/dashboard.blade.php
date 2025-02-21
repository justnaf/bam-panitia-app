<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('includes.taost')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @hasrole(['Admin', 'SuperAdmin', 'Instruktur'])
                    <div class="flex flex-col max-w-sm mx-auto items-center">
                        <p>
                            Hallo Selamat Datang
                        </p>
                    </div>
                    @else
                    <div class="text-center">
                        <h1 class="font-extrabold text-2xl">
                            Kamu Bukan Panitia
                        </h1>
                        @if(!$submission || ($submission->status && $submission->status == 'pending'))
                        @if($submission && $submission->status == 'pending')
                        <p class="text-orange-500">Tunggu Proses Approval Pengajuan Aksesmu</p>
                        @else
                        <p>
                            Silahkan Buat Pengajuan Untuk Mendapatkan Akses Panitia
                        </p>
                        <hr class="border-b-1 border-gray-400 my-4 mx-auto max-w-lg">
                        <h1 class="font-bold text-lg mb-2">Form Pengajuan Akses</h1>
                        <form method="POST" action="{{route('submission.role')}}" class="max-w-lg mx-auto" x-data="submissionForm" x-ref="submissionform">
                            @csrf
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="role">
                                    Sebagai
                                </label>
                                <select class="placeholder:italic placeholder:text-slate-400 block bg-white w-full border border-slate-300 rounded-md p-2 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm" name="role" id="role" required>
                                    <option value="" disabled selected>-- Silahkan Pilih Role--</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Instruktur">Instruktur</option>
                                </select>
                            </div>
                            <div class="w-full px-1">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                                    Alasan Pengajuan
                                </label>
                                <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" name="reason" id="reason" type="text"></textarea>
                            </div>
                            <div class="p-1">
                                <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="confirmSubmission"><span class="font-extrabold">Ajukan</span></button>
                            </div>
                        </form>
                        @endif
                        @endif
                    </div>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
    @push('addedScript')
    <script>
        function submissionForm() {
            return {
                confirmSubmission() {
                    Swal.fire({
                        title: 'Yakin?'
                        , text: "Pastikan Alasan Kamu Sudah Sesuaii!"
                        , icon: 'warning'
                        , showCancelButton: true
                        , confirmButtonColor: '#d33'
                        , cancelButtonColor: '#3085d6'
                        , confirmButtonText: 'Sudah'
                        , cancelButtonText: 'Cancel'
                    , }).then((result) => {
                        if (result.isConfirmed) {
                            // Explicitly reference the form element and submit it
                            this.$refs.submissionform.submit();
                        }
                    });
                }
            , };
        }

    </script>
    @endpush
</x-app-layout>
