<aside id="sidebar" class="bg-primary flex flex-col shrink-0 relative z-30 h-screen">
    <!-- Header sidebar: logo + tombol toggle -->
    <div class="flex items-center justify-between px-3 py-4 border-b border-white/10 shrink-0">
        <div class="flex items-center gap-2 overflow-hidden min-w-0">
            <span class="text-yellow-400 text-[20px] shrink-0 leading-none">
                <i class="ti ti-flame"></i>
            </span>
            <span class="sl text-white font-bold text-[17px] tracking-wide leading-none">Dashboard</span>
        </div>
        <button id="toggle-sidebar-btn" class="w-7 h-7 flex items-center justify-center rounded-lg
                    text-white/70 hover:text-white transition-colors shrink-0">
            <i id="toggle-icon" class="ti ti-layout-sidebar text-[18px]"></i>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto py-2 space-y-0 px-2">
        @if(auth()->user()->role == 'admin')
        <!-- Menu Utama label -->
        <p class="sl px-2 pt-3 pb-1.5 text-[10px] font-semibold text-blue-300 uppercase tracking-widest">Admin</p>

        <!-- Home -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-home text-[18px] shrink-0"></i>
            <a href="{{ route('dashboard') }}" class="sl">Dashboard</a>
        </div>      

        <!-- Users -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-users text-[18px] shrink-0"></i>
            <a href="{{ route('admin.users.index') }}" class="sl">Users</a>
        </div>

        <!-- Users -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-brand-airtable text-[18px] shrink-0"></i>
            <a href="{{ route('company.index') }}" class="sl">Perusahaan</a>
        </div>      

        <!-- Service -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-settings-cog text-[18px] shrink-0"></i>
            <a href="{{ route('layanans.index') }}" class="sl">Layanan</a>
        </div>      

        <!-- Counter -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-ticket text-[18px] shrink-0"></i>
            <a href="{{ route('lokets.index') }}" class="sl">Konter</a>
        </div>

        <!-- Counter -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-clothes-rack text-[18px] shrink-0"></i>
            <a href="{{ route('antrians.index') }}" class="sl">Antrian</a>
        </div>

        <!-- Divider Menu Lainnya -->
        <p class="sl px-2 pt-4 pb-1.5 text-[10px] font-semibold text-blue-300 uppercase tracking-widest">Operator</p>

        <!-- Home -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-home text-[18px] shrink-0"></i>
            <a href="{{ route('dashboard') }}" class="sl">Dashboard</a>
        </div>

        <!-- Profile -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-user-cog text-[18px] shrink-0"></i>
            <a href="{{ route('client.profile.index') }}" class="sl">Profil</a>
        </div>      

         <!-- Home Screen Setting -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-device-imac text-[18px] shrink-0"></i>
            <a href="{{ route('client.frontscreen.managementfrontscreen') }}" class="sl">Pengaturan Tampilan</a>
        </div>        

        <!-- Home Screen Setting -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-ticket text-[18px] shrink-0"></i>
            <a href="{{ route('client.qounter.index') }}" class="sl">Konter</a>
        </div>
        @else      
        <!-- Divider Menu Lainnya -->
        <p class="sl px-2 pt-4 pb-1.5 text-[10px] font-semibold text-blue-300 uppercase tracking-widest">Operator</p>

        <!-- Home -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-home text-[18px] shrink-0"></i>
            <a href="{{ route('dashboard') }}" class="sl">Dashboard</a>
        </div>

        <!-- Profile -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-user-cog text-[18px] shrink-0"></i>
            <a href="{{ route('client.profile.index') }}" class="sl">Profil</a>
        </div>      

         <!-- Home Screen Setting -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-device-imac text-[18px] shrink-0"></i>
            <a href="{{ route('client.frontscreen.managementfrontscreen') }}" class="sl">Pengaturan Tampilan</a>
        </div>        

        <!-- Home Screen Setting -->
        <div class="menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg
                  text-blue-100 hover:text-white cursor-pointer transition-colors text-[13px]" data-tip="Beranda"
            style="animation-delay:0ms">
            <i class="ti ti-ticket text-[18px] shrink-0"></i>
            <a href="{{ route('client.qounter.index') }}" class="sl">Konter</a>
        </div>
        @endif        
            
    </nav>
</aside>
