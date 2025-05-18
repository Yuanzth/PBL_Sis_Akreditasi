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
              <li class="nav-item">
                <a href="{{ url('/documents') }}" class="nav-link {{ ($activeMenu == 'documents') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Profile User</p>
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
                    <li class="nav-item">
                        <a href="{{ url('/kriteria1') }}" class="nav-link {{ ($activeMenu == 'kriteria1') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 1</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria2') }}" class="nav-link {{ ($activeMenu == 'kriteria2') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 2</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria3') }}" class="nav-link {{ ($activeMenu == 'kriteria3') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 3</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria4') }}" class="nav-link {{ ($activeMenu == 'kriteria4') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 4</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria5') }}" class="nav-link {{ ($activeMenu == 'kriteria5') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 5</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria6') }}" class="nav-link {{ ($activeMenu == 'kriteria6') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 6</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria7') }}" class="nav-link {{ ($activeMenu == 'kriteria7') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 7</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria8') }}" class="nav-link {{ ($activeMenu == 'kriteria8') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 8</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kriteria9') }}" class="nav-link {{ ($activeMenu == 'kriteria9') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kriteria 9</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/validasi-data') }}" class="nav-link {{ ($activeMenu == 'validasi') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-check-square"></i>
                    <p>Validasi Data</p>
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

@push('css')
<style>
    .sidebar {
        background-color: #343a40;
        color: #fff;
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
</style>
@endpush