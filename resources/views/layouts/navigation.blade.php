<aside class="bg-gray-500 text-white transition-all duration-300 ease-in-out " :class="show ? 'w-1/2 md:w-52' : 'w-0 md:w-16'">
    <template x-if="show">
        <div>
            <section class="py-5 block bg-white px-3 mb-3">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-6 w-auto fill-current text-gray-800" />
                </a>
            </section>
            <section class="px-3 py-2 space-y-2">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-dropdown-nav-link title="Kegiatan" :active="request()->routeIs('events.*')">
                    <div class="mb-2">
                        <a href="{{route('events.index')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Semua Kegiatan
                        </a>
                    </div>
                </x-dropdown-nav-link>
                <x-dropdown-nav-link title="Sesi" :active="request()->routeIs('sesi.*')">
                    <div class="mb-2">
                        <a href="{{route('sesi.index')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Semua Sesi
                        </a>
                    </div>
                </x-dropdown-nav-link>
                <x-nav-link :href="route('modelActiveEvents.index')" :active="request()->routeIs('modelActiveEvents.*')">
                    {{ __('Invite Pengguna') }}
                </x-nav-link>
                <x-dropdown-nav-link title="Presensi" :active="request()->routeIs('presences.*')">
                    <div class="mb-2">
                        <a href="{{route('presences.listview')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            {{ __('Semua Presensi') }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{route('presences.index')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            {{ __('QR Presensi') }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{route('presences.majelis.index')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            {{ __('Presensi Kajian') }}
                        </a>
                    </div>
                </x-dropdown-nav-link>
                <x-dropdown-nav-link title="Data Kamar" :active="request()->routeIs('restroom.*')">
                    <div class="mb-2">
                        <a href="{{route('restroom.index')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            {{ __('Data Kamar') }}
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{route('restroom.indexDistri')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            {{ __('Data Peserta & Kamar') }}
                        </a>
                    </div>
                </x-dropdown-nav-link>
                <x-dropdown-nav-link title="Penilaian" :active="request()->routeIs('grades.*')">
                    <div class="mb-2">
                        <a href="{{route('grades.index')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Semua Penilaian
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{route('grades.graduate.index')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Kelulusan
                        </a>
                    </div>
                </x-dropdown-nav-link>
                <x-nav-link :href="route('esummary.index')" :active="request()->routeIs('esummary.*')">
                    {{ __('Summary Kegiatan') }}
                </x-nav-link>
                <x-dropdown-nav-link title="Data Kesehatan" :active="request()->routeIs('health.*')">
                    <div class="mb-2">
                        <a href="{{route('health.alergic')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Alergi
                        </a>
                    </div>
                    <div class="mb-2">
                        <a href="{{route('health.diseases')}}" class="hover:bg-emerald-500 flex py-2 px-2 rounded-md w-full">
                            Riwayat Penyakit
                        </a>
                    </div>
                </x-dropdown-nav-link>
            </section>
        </div>
    </template>
    <template x-if="!show">
        <div class="hidden md:block">
            <div class="py-5 flex justify-center bg-white px-3 text-black">
                <span class="block mx-auto"><i class="fas fa-mug-hot"></i></span>
            </div>
            <section class="px-3 py-2 space-y-2">
                <x-nav-link class="justify-center" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i class="fas fa-home" title="Dashboard"></i>
                </x-nav-link>
                <x-nav-link class="justify-center" :href="route('events.index')" :active="request()->routeIs('events.*')">
                    <i class="fas fa-clipboard-list" title="Kegiatan"></i>
                </x-nav-link>
                <x-nav-link class="justify-center" :href="route('sesi.index')" :active="request()->routeIs('sesi.*')">
                    <i class="fas fa-calendar-week" title="Sesi"></i>
                </x-nav-link>
                <x-nav-link class="justify-center" :href="route('modelActiveEvents.index')" :active="request()->routeIs('modelActiveEvents.*')">
                    <i class="fas fa-user-plus" title="Invite Pengguna"></i>
                </x-nav-link>
                <x-nav-link class="justify-center" :href="route('restroom.index')" :active="request()->routeIs('restroom.*')">
                    <i class="fas fa-building" title="Data Kamar"></i>
                </x-nav-link>
                <x-nav-link class="justify-center" :href="route('presences.listview')" :active="request()->routeIs('presences.*')">
                    <i class="fas fa-qrcode" title="Presensi"></i>
                </x-nav-link>
                <x-nav-link class="justify-center" :href="route('grades.index')" :active="request()->routeIs('grades.*')">
                    <i class="fas fa-clipboard-check" title="Penilaian"></i>
                </x-nav-link>
                <x-nav-link class="justify-center" :href="route('esummary.index')" :active="request()->routeIs('esummary.*')">
                    <i class="fas fa-chart-pie" title="Event Summary"></i>
                </x-nav-link>
            </section>
        </div>
    </template>
</aside>
