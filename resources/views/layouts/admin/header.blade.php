<header id="topbar" class="h-[60px] bg-white border-b border-gray-200
             flex items-center justify-between px-5 shrink-0 sticky top-0 z-20">
    <!-- Kiri: info sekolah -->
    <div class="flex flex-col leading-tight">
        <span class="text-[11px] text-gray-400 font-normal">{{ auth()->user()->role ?? 'Staff' }}</span>
        <span class="text-[13.5px] font-semibold text-gray-800">Hello, Welcome {{ ucfirst(Auth::user()->name) }} 👋</span>
    </div>

    <!-- Kanan: notif + profil -->
    <div class="flex items-center gap-2 relative">
        <!-- Notifikasi -->
        <!-- <button class="w-9 h-9 flex items-center justify-center rounded-lg
                       text-gray-500 hover:bg-gray-100 relative transition-colors">
            <i class="ti ti-bell text-[19px]"></i>
            <span class="absolute top-1.5 right-1.5 w-[7px] h-[7px]
                       bg-red-500 rounded-full ring-2 ring-white"></span>
        </button> -->

        <!-- Avatar profil -->
        <button id="btn-profile"
            class="w-9 h-9 rounded-full bg-blue-100 text-brand font-bold
                 text-[13px] flex items-center justify-center hover:ring-2 hover:ring-brand/30 transition-all select-none">
            {{ strtoupper(collect(explode(' ', Auth::user()->name))->map(fn($s) => substr($s, 0, 1))->take(2)->implode('')) }}
        </button>

        <!-- Dropdown profil -->
        <div id="profile-dropdown" class="absolute right-0 top-[46px] w-52 bg-white
                 border border-gray-200 rounded-xl shadow-xl z-50 dp-hide overflow-hidden">
            <!-- Header dropdown -->
            <div
                class="px-4 py-3 bg-gradient-to-br from-blue-50 to-white border-b border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand text-white font-bold
                        text-[13px] flex items-center justify-center shrink-0">{{ strtoupper(collect(explode(' ', Auth::user()->name))->map(fn($s) => substr($s, 0, 1))->take(2)->implode('')) }}</div>
                <div class="min-w-0">
                    <p class="text-[13px] font-semibold text-gray-800 truncate">{{ ucfirst(Auth::user()->name) }}</p>
                    <p class="text-[11px] text-gray-400 truncate">{{ auth()->user()->role ?? 'Staff' }}</p>
                </div>
            </div>

            <!-- Menu items -->
            <div class="py-1">
                <!-- <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px]
                     text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="ti ti-user text-[16px] text-gray-400"></i>
                    Profil Saya
                </a> -->
                <!-- <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-[13px]
                     text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="ti ti-settings text-[16px] text-gray-400"></i>
                    Pengaturan
                </a> -->
            </div>

            <div class="border-t border-gray-100"></div>

            <div class="py-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 px-4 py-2.5 text-[13px] text-red-500 hover:bg-red-50 transition-colors">
                        <i class="ti ti-logout text-[16px]"></i>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
