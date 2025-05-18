php
<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" style="background-color: #D9D9D9; color: #000;">
            <div class="input-group-append">
                <button class="btn btn-sidebar" style="background-color: #D9D9D9;">
                    <i class="fas fa-search fa-fw" style="color: #000;"></i>
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

            @if($levelKode == 'ADM')
                <!-- Menu Admin -->
                <li class="nav-header">Manajemen Pengguna</li>
                <li class="nav-item">
                    <a href="{{ url('/users') }}" class="nav-link {{ ($activeMenu == 'users') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Data Pengguna</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/levels') }}" class="nav-link {{ ($activeMenu == 'levels') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Level Pengguna</p>
                    </a>
                </li>
                <li class="nav-header">Manajemen Data</li>
                <li class="nav-item">
                    <a href="{{ url('/data-kriteria') }}" class="nav-link {{ ($activeMenu == 'data-kriteria') ? 'active' : '' }}">
                        <img src="{{ asset('dashboard/icons/icon_data_kriteria.png') }}" class="nav-icon" style="width: 18px; height: 18px;">
                        <p>Data Kriteria</p>
                    </a>
                </li>
            @endif

            @if(in_array($levelKode, ['ADM', 'KPS']))
                <!-- Menu Admin & KPS_Kajur -->
                <li class="nav-header">Manajemen Dokumen</li>
                <li class="nav-item">
                    <a href="{{ url('/documents') }}" class="nav-link {{ ($activeMenu == 'documents') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Dokumen Akreditasi</p>
                    </a>
                </li>
                <li class="nav-item {{ ($activeMenu == 'kriteria') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ ($activeMenu == 'kriteria') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Data Kriteria
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @for($i = 1; $i <= 9; $i++)
                            <li class="nav-item">
                                <a href="{{ url('/kriteria' . $i) }}" class="nav-link {{ ($activeMenu == 'kriteria' . $i) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kriteria {{ $i }}</p>
                                </a>
                            </li>
                        @endfor
                    </ul>
                </li>
            @endif

            @if(in_array($levelKode, ['ADM', 'KPS', 'KJM', 'DIR']))
                <!-- Menu Semua Level -->
                <li class="nav-header">Pengguna</li>
                <li class="nav-item">
                    <a href="{{ url('/profile-user') }}" class="nav-link {{ ($activeMenu == 'profile-user') ? 'active' : '' }}">
                        <img src="{{ asset('dashboard/icons/icon_profile_user.png') }}" class="nav-icon" style="width: 18px; height: 18px; margin-right: 8px;">
                        <p>Profile User</p>
                    </a>
                </li>
                <li class="nav-header">Data</li>
                <li class="nav-item">
                    <a href="{{ url('/data-kriteria') }}" class="nav-link {{ ($activeMenu == 'data-kriteria') ? 'active' : '' }}">
                        <img src="{{ asset('dashboard/icons/icon_data_kriteria.png') }}" class="nav-icon" style="width: 18px; height: 18px; margin-right: 8px;">
                        <p>Data Kriteria</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/validasi-data') }}" class="nav-link {{ ($activeMenu == 'validasi-data') ? 'active' : '' }}">
                        <img src="{{ asset('dashboard/icons/icon_validasi_data.png') }}" class="nav-icon" style="width: 18px; height: 18px; margin-right: 8px;">
                        <p>Validasi Data</p>
                    </a>
                </li>
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

    <!-- Logout Sticky Bottom -->
    <div class="logout-link mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link w-100 text-left" style="color: #fff; background: none; border: none;">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p style="display: inline;">Logout</p>
            </button>
        </form>
    </div>
</div>

@push('css')
<style>
    .sidebar {
        background-color: #343a40;
        color: #fff;
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }
    .nav-link {
        color: #fff !important;
    }
    .nav-link:hover {
        background-color: #495057;
    }
    .nav-link.active {
        background-color: #495057 !important;
    }
    .nav-header {
        color: #adb5bd;
        padding: 10px 20px;
        font-size: 0.9rem;
        text-transform: uppercase;
    }
    .nav-treeview .nav-item {
        padding-left: 20px;
    }
    .nav-treeview .nav-link {
        color: #fff;
    }
    .nav-treeview .nav-link:hover {
        background-color: #495057;
    }
    .nav-treeview .nav-link.active {
        background-color: #495057;
    }
    .right {
        float: right;
        margin-top: 3px;
    }
    .logout-link {
        padding: 10px 20px;
        background-color: #343a40;
    }
    .logout-link button:hover {
        background-color: #495057;
    }
</style>
@endpush