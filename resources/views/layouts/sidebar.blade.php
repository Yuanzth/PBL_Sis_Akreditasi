<div class="sidebar d-flex flex-column justify-content-between"
    style="height: 100vh; background-color: #2E7D32; color: white; padding: 15px; overflow-x: hidden;">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        {{-- <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search"
                style="background-color: #D9D9D9; color: #000;">
            <div class="input-group-append">
                <button class="btn btn-sidebar" style="background-color: #D9D9D9;">
                    <i class="fas fa-search fa-fw" style="color: #000;"></i>
                </button>
            </div>
        </div> --}}
        <!-- Menu Wrapper -->
        <div class="menu-wrapper d-flex flex-column flex-grow-1" style="overflow-x: hidden;">

            <!-- Sidebar Menu -->
            <nav class="mt-2" style="flex: 1 1 auto;">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Menu Utama untuk Semua Level -->
                    <li class="nav-header"
                        style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">Menu
                        Utama
                    </li>
                    <li class="nav-item" style="margin: 5px 0;">
                        <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}"
                            style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                  background-color: {{ ($activeMenu == 'dashboard') ? '#2196F3' : 'transparent' }};"
                            onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                            onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'dashboard') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                            <i class="nav-icon fas fa-tachometer-alt" style="color: #FFFFFF; margin-right: 15px;"></i>
                            <p style="color: #FFFFFF; margin: 0;">Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item" style="margin: 5px 0;">
                        <a href="{{ url('/profile-user') }}"
                            class="nav-link {{ ($activeMenu == 'profile-user') ? 'active' : '' }}" style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                  background-color: {{ ($activeMenu == 'profile-user') ? '#2196F3' : 'transparent' }};"
                            onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                            onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'profile-user') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                            <i class="nav-icon fas fa-user" style="color: #FFFFFF; margin-right: 15px;"></i>
                            <p style="color: #FFFFFF; margin: 0;">Profile User</p>
                        </a>
                    </li>

                    <!-- Ambil Level Pengguna -->
                    @php
                        $user = Auth::user();
                        $levelKode = $user ? $user->level->level_kode : '';
                    @endphp

                    <!-- Menu untuk Admin -->
                    @if($levelKode == 'Admin')
                        @php
                            $kriteria = DB::table('m_kriteria')->where('id_user', $user->id_user)->first();
                            $kriteriaId = $kriteria ? $kriteria->id_kriteria : null;
                        @endphp
                        <li class="nav-header"
                            style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">Data
                            Kriteria</li>
                        <li class="nav-item"
                            style="margin: 5px 0; {{ ($activeMenu == 'kriteria') ? 'background-color: #2196F3;' : '' }}"
                            class="{{ ($activeMenu == 'kriteria') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ ($activeMenu == 'kriteria') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                                  background-color: {{ ($activeMenu == 'kriteria') ? '#2196F3' : 'transparent' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'kriteria') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <i class="nav-icon fas fa-table" style="color: #FFFFFF; margin-right: 15px;"></i>
                                <p style="color: #FFFFFF; margin: 0;">
                                    Data Kriteria
                                    <i class="fas fa-angle-left right"
                                        style="color: #FFFFFF; float: right; margin-top: 3px;"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview"
                                style="list-style: none; padding: 0; margin: 0; max-width: 100%; overflow-x: hidden;">
                                @for($i = 1; $i <= 9; $i++)
                                    <li class="nav-item" style="padding-left: 15px; margin: 5px 0;">
                                        @if($kriteriaId == $i)
                                            <a href="{{ url('/kriteria/' . $i) }}"
                                                class="nav-link {{ ($activeMenu == 'kriteria' . $i) ? 'active' : '' }}"
                                                style="color: #FFFFFF; padding: 8px 15px; display: flex; align-items: center; 
                                                                                          background-color: {{ ($activeMenu == 'kriteria' . $i) ? '#2196F3' : 'transparent' }};"
                                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'kriteria' . $i) ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                                <i class="far fa-circle nav-icon" style="color: #FFFFFF; margin-right: 12px;"></i>
                                                <p style="color: #FFFFFF; margin: 0;">Kriteria {{ $i }}</p>
                                            </a>
                                        @else
                                            <a href="#" class="nav-link disabled"
                                                style="color: #B0BEC5; padding: 8px 15px; display: flex; align-items: center; cursor: not-allowed; opacity: 0.5;">
                                                <i class="far fa-circle nav-icon" style="color: #B0BEC5; margin-right: 12px;"></i>
                                                <p style="color: #B0BEC5; margin: 0;">Kriteria {{ $i }}</p>
                                            </a>
                                        @endif
                                    </li>
                                @endfor
                            </ul>
                        </li>
                    @endif

                    <!-- Menu untuk KPS/Kajur -->
                    @if($levelKode == 'KPS_Kajur')
                        <li class="nav-header"
                            style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">
                            Validasi
                        </li>
                        <li class="nav-item" style="margin: 5px 0;">
                            <a href="{{ url('/validasi-data') }}"
                                class="nav-link {{ ($activeMenu == 'validasi-data') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                                  background-color: {{ ($activeMenu == 'validasi-data') ? '#2196F3' : 'transparent' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'validasi-data') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <img src="{{ asset('dashboard/icons/icon_validasi_data.png') }}" class="nav-icon"
                                    style="width: 18px; height: 18px; margin-right: 8px;">
                                <p style="color: #FFFFFF; margin: 0;">Validasi Data</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk KJM/Direktur -->
                    @if(in_array($levelKode, ['KJM', 'Direktur']))
                        <li class="nav-header"
                            style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">
                            Validasi
                        </li>
                        <li class="nav-item" style="margin: 5px 0;">
                            <a href="{{ url('/validasi-data') }}"
                                class="nav-link {{ ($activeMenu == 'validasi-data') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                                  background-color: {{ ($activeMenu == 'validasi-data') ? '#2196F3' : 'transparentmint' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'validasi-data') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <img src="{{ asset('dashboard/icons/icon_validasi_data.png') }}" class="nav-icon"
                                    style="width: 18px; height: 18px; margin-right: 8px;">
                                <p style="color: #FFFFFF; margin: 0;">Validasi Data</p>
                            </a>
                        </li>
                        <li class="nav-header"
                            style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">
                            Finalisasi
                        </li>
                        <li class="nav-item" style="margin: 5px 0;">
                            <a href="{{ url('/finalisasi-dokumen') }}"
                                class="nav-link {{ ($activeMenu == 'finalisasi-dokumen') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                                  background-color: {{ ($activeMenu == 'finalisasi-dokumen') ? '#2196F3' : 'transparent' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'finalisasi-dokumen') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <i class="nav-icon fas fa-file-export" style="color: #FFFFFF; margin-right: 10px;"></i>
                                <p style="color: #FFFFFF; margin: 0;">Finalisasi Dokumen</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    <!-- Logout Button -->
    <div style="padding: 15px;">
        <a href="{{ route('logout') }}" class="nav-link"
            style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; background-color: transparent;"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
            onmouseout="this.style.backgroundColor='transparent'; this.style.color='#FFFFFF';">
            <i class="nav-icon fas fa-sign-out-alt" style="color: #FFFFFF; margin-right: 15px;"></i>
            <p style="color: #FFFFFF; margin:0 ;">Logout</p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

@push('css')
    <style>
        /* Ensure dropdown stays within sidebar */
        .nav-treeview {
            width: 100%;
            box-sizing: border-box;
        }

        .nav-treeview .nav-item {
            width: 100%;
        }

        .nav-treeview .nav-link {
            width: 100%;
            box-sizing: border-box;
        }

        /* Sembunyikan teks logout saat sidebar collapse */
        .sidebar-collapse .logout-text {
            display: none !important;
        }
    </style>
@endpush