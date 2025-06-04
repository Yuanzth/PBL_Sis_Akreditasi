<div class="sidebar d-flex flex-column justify-content-between"
    style="height: 100vh; background-color: #0B6B4F; color: white; padding: 15px; overflow-x: hidden;">
    <div class="form-inline mt-2">
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
                        <a href="{{ url('/profile') }}"
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

                    <!-- Menu untuk Admin Kriteria (Admin1 hingga Admin9) -->
                    @if(in_array($levelKode, ['Admin1', 'Admin2', 'Admin3', 'Admin4', 'Admin5', 'Admin6', 'Admin7', 'Admin8', 'Admin9']))
                        @php
                            // Map id_level ke id_kriteria (id_level 5 = Admin1 = Kriteria 1, dst.)
                            $kriteriaId = $user->id_level - 4; // Admin1 (id_level 5) -> Kriteria 1
                        @endphp
                        <li class="nav-header"
                            style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">Data
                            Kriteria</li>
                        <li class="nav-item" style="margin: 5px 0;">
                            <a href="{{ url('/kriteria/' . $kriteriaId) }}"
                                class="nav-link {{ ($activeMenu == 'kriteria') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                      background-color: {{ ($activeMenu == 'kriteria') ? '#2196F3' : 'transparent' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'kriteria') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <i class="nav-icon fas fa-table" style="color: #FFFFFF; margin-right: 15px;"></i>
                                <p style="color: #FFFFFF; margin: 0;">Kriteria {{ $kriteriaId }}</p>
                            </a>
                        </li>
                    @endif

                    <!-- Menu untuk KPS/Kajur -->
                    @if($levelKode == 'KPS_Kajur')
                        <li class="nav-header"
                            style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">
                            Validasi
                        </li>
                        <li class="nav-item" style="margin: 5px 0;">
                            <a href="{{ url('/validasitahapsatu') }}"
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
                            <a href="{{ url('/validasitahapdua') }}"
                                class="nav-link {{ ($activeMenu == 'validasi-tahap-dua') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                                  background-color: {{ ($activeMenu == 'validasi-tahap-dua') ? '#2196F3' : 'transparent' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'validasi-tahap-dua') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <img src="{{ asset('dashboard/icons/icon_validasi_data.png') }}" class="nav-icon"
                                    style="width: 18px; height: 18px; margin-right: 8px;">
                                <p style="color: #FFFFFF; margin: 0;">Validasi Tahap Dua</p>
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

                    <!-- Menu untuk SuperAdmin -->
                    @if($levelKode == 'SuperAdmin')
                        <li class="nav-header"
                            style="color: #FFFFFF; padding: 10px 15px; font-size: 0.9rem; text-transform: uppercase;">
                            Pengelolaan
                        </li>
                        <li class="nav-item" style="margin: 5px 0;">
                            <a href="{{ route('users.manage') }}"
                                class="nav-link {{ ($activeMenu == 'manage-users') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                      background-color: {{ ($activeMenu == 'manage-users') ? '#2196F3' : 'transparent' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'manage-users') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <i class="nav-icon fas fa-users" style="color: #FFFFFF; margin-right: 15px;"></i>
                                <p style="color: #FFFFFF; margin: 0;">Kelola Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item" style="margin: 5px 0;">
                            <a href="{{ route('kriteria.manage') }}"
                                class="nav-link {{ ($activeMenu == 'manage-kriteria') ? 'active' : '' }}"
                                style="color: #FFFFFF; padding: 10px 15px; display: flex; align-items: center; 
                                      background-color: {{ ($activeMenu == 'manage-kriteria') ? '#2196F3' : 'transparent' }};"
                                onmouseover="this.style.backgroundColor='#4CAF50'; this.style.color='#FFFFFF';"
                                onmouseout="this.style.backgroundColor='{{ ($activeMenu == 'manage-kriteria') ? '#2196F3' : 'transparent' }}'; this.style.color='#FFFFFF';">
                                <i class="nav-icon fas fa-table" style="color: #FFFFFF; margin-right: 15px;"></i>
                                <p style="color: #FFFFFF; margin: 0;">Kelola Kriteria</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>

@push('css')
    <style>
        /* dropdown tetap di dalam sidebar */
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

        /* Memusatkan ikon di mode sidebar-mini saat sidebar di-collapse */
        .sidebar-mini.sidebar-collapse .nav-link {
            display: flex;
            justify-content: center; 
            align-items: center; 
            padding: 0; 
            margin: 0 auto; 
            width: 100%; 
        }

        /* hide teks di mode mini */
        .sidebar-mini.sidebar-collapse .nav-link p {
            display: none; /* hide teks saat sidebar di-minimize */
        }

        .sidebar-mini.sidebar-collapse .nav-icon {
            margin: 0 auto; 
            font-size: 1.2rem;
            line-height: 1; 
        }

        /*  ikon berupa gambar */
        .sidebar-mini.sidebar-collapse .nav-icon[src] {
            margin: 0 auto;
            width: 24px; 
            height: 24px;
        }

        .sidebar-mini.sidebar-collapse .nav-item {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px; 
            margin: 0;
        }

        .sidebar-mini.sidebar-collapse .main-sidebar {
            width: 60px; 
        }

        .sidebar-mini.sidebar-collapse .sidebar {
            overflow: hidden;
        }

        .sidebar-mini.sidebar-collapse .nav-header {
            display: none;
        }

        .sidebar-mini.sidebar-collapse .nav-pills {
            padding: 0;
            margin: 0;
        }
    </style>
@endpush