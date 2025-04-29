
@extends('layouts.template')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h1 class="display-4">🎉 Selamat Datang, {{ Auth::user()->nama }}! 🎉</h1>
                <p class="lead">Apa yang ingin Anda lakukan hari ini?</p>
            </div>
        </div>

        <div class="row">
            @if(in_array($userRole, ['ADM']))
                <!-- Admin Dashboard -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>User Management</h3>
                            <p>Kelola User dengan Mudah!</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <a href="{{ url('/user') }}" class="small-box-footer">
                            Akses Sekarang <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>Level System</h3>
                            <p>Atur Hak Akses User</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <a href="{{ url('/level') }}" class="small-box-footer">
                            Manage Levels <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endif

            @if(in_array($userRole, ['ADM', 'MNG']))
                <!-- Manager & Admin -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Kategori</h3>
                            <p>Kelola Kategori Barang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <a href="{{ url('/kategori') }}" class="small-box-footer">
                            Lihat Kategori <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Supplier</h3>
                            <p>Kelola Partner Bisnis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <a href="{{ url('/supplier') }}" class="small-box-footer">
                            Cek Supplier <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endif

            @if(in_array($userRole, ['ADM', 'MNG', 'STF']))
                <!-- All Staff -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>Penjualan</h3>
                            <p>Transaksi Baru? Yuk!</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                        <a href="{{ url('/penjualan') }}" class="small-box-footer">
                            Lihat Transaksi <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-orange">
                        <div class="inner">
                            <h3>Stok</h3>
                            <p>Pantau Stok Barangmu!</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <a href="{{ url('/stok') }}" class="small-box-footer">
                            Cek Stok <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endif

            {{-- @if(in_array($userRole, ['ADM', 'MNG']))
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Laporan</h3>
                        <p>Analisis Bisnis</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Generate Report <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endif --}}
        </div>

        {{-- <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-gradient-primary">
                        <h3 class="card-title">📊 Quick Stats</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info-circle"></i> Hai Superstar! 🚀</h5>
                            <p class="mb-0">
                                Selamat! Hari ini Anda telah menyelesaikan 15 transaksi dengan total penjualan Rp
                                12.450.000!
                                <br>Teruskan semangatnya! 💪
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <style>
        .small-box {
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .bg-purple {
            background-color: #6f42c1 !important;
            color: white;
        }

        .bg-orange {
            background-color: #fd7e14 !important;
            color: white;
        }
    </style>
@endsection