<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            @php
                $user = Auth::user();
                $levelKode = $user ? $user->level->level_kode : '';
            @endphp

            @if($levelKode == 'Admin')
                <!-- Menu Admin -->
                <li class="nav-header">Profile User</li>
                <li class="nav-item">
                    <a href="{{ url('/users') }}" class="nav-link {{ ($activeMenu == 'users') ? 'active' : '' }}">
                        <img src="{{ asset('dashboard/icons/icon_profile.png') }}" class="nav-icon"
                            style="width: 18px; height: 18px;">
                        <p>Profile User</p>
                    </a>
                </li>

                <li class="nav-header">Manajemen Data</li>
                <li class="nav-item">
                    <a href="{{ url('/data-kriteria') }}"
                        class="nav-link {{ ($activeMenu == 'data-kriteria') ? 'active' : '' }}">
                        <img src="{{ asset('dashboard/icons/icon_data_kriteria.png') }}" class="nav-icon"
                            style="width: 18px; height: 18px;">
                        <p>Data Kriteria</p>
                    </a>
                </li>

            @endif

            @if(in_array($levelKode, ['Admin', 'KPS_Kajur']))
                <!-- Menu Admin & KPS_Kajur -->
                <li class="nav-header">Manajemen Dokumen</li>
                <li class="nav-item">
                    <a href="{{ url('/documents') }}" class="nav-link {{ ($activeMenu == 'documents') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Dokumen Akreditasi</p>
                    </a>
                </li>
            @endif

            @if(in_array($levelKode, ['Admin', 'KPS_Kajur', 'KJM', 'Direktur']))
                <!-- Menu Semua Level -->
                <li class="nav-header">Laporan</li>
                <li class="nav-item">
                    <a href="{{ url('/reports') }}" class="nav-link {{ ($activeMenu == 'reports') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Laporan Akreditasi</p>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>