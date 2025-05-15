@extends('layouts.template')

@push('css')
<style>
    .container-fluid {
        padding: 20px;
    }

    .welcome-card {
        background: #f2f2f2;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 16px;
        color: #333;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        grid-gap: 20px;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 15px;
    }

    .category-grid .info-box {
        color: white;
        border-radius: 10px;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        min-height: 80px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .info-box-content {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-box-text {
        font-size: 13px;
        font-weight: 500;
    }

    .info-box-number {
        font-size: 22px;
        font-weight: bold;
    }

    .info-box-icon img {
        width: 32px;
        height: 32px;
        opacity: 1;
    }

    .placeholder-chart {
        background: #eee;
        border-radius: 12px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #555;
        font-size: 14px;
        min-height: 500px;
    }

    .penetapan {
        background-color: #23C3D8;
    }

    .pelaksanaan {
        background-color: #1CA7EC;
    }

    .evaluasi {
        background-color: #787FF6;
    }

    .pengendalian {
        background-color: #4B77BE;
    }

    .peningkatan {
        background-color: #4555BA;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Welcome Message -->
    <div class="welcome-card">
        Selamat Datang, Admin!
    </div>

    <!-- Dashboard Layout -->
    <div class="dashboard-grid">
        <!-- Left Grid -->
        <div class="category-grid">
            <div class="info-box penetapan">
                <div class="info-box-content">
                    <span class="info-box-text">Penetapan</span>
                    <span class="info-box-number">4</span>
                </div>
                <span class="info-box-icon">
                    <img src="{{ asset('dashboard/icons/icon_penetapan.png') }}" alt="Penetapan Icon">
                </span>
            </div>
            <div class="info-box pelaksanaan">
                <div class="info-box-content">
                    <span class="info-box-text">Pelaksanaan</span>
                    <span class="info-box-number">4</span>
                </div>
                <span class="info-box-icon">
                    <img src="{{ asset('dashboard/icons/icon_pelaksanaan.png') }}" alt="Pelaksanaan Icon">
                </span>
            </div>
            <div class="info-box evaluasi">
                <div class="info-box-content">
                    <span class="info-box-text">Evaluasi</span>
                    <span class="info-box-number">4</span>
                </div>
                <span class="info-box-icon">
                    <img src="{{ asset('dashboard/icons/icon_evaluasi.png') }}" alt="Evaluasi Icon">
                </span>
            </div>
            <div class="info-box pengendalian">
                <div class="info-box-content">
                    <span class="info-box-text">Pengendalian</span>
                    <span class="info-box-number">4</span>
                </div>
                <span class="info-box-icon">
                    <img src="{{ asset('dashboard/icons/icon_pengendalian.png') }}" alt="Pengendalian Icon">
                </span>
            </div>
            <div class="info-box peningkatan">
                <div class="info-box-content">
                    <span class="info-box-text">Peningkatan</span>
                    <span class="info-box-number">4</span>
                </div>
                <span class="info-box-icon">
                    <img src="{{ asset('dashboard/icons/icon_peningkatan.png') }}" alt="Peningkatan Icon">
                </span>
            </div>
        </div>

        <!-- Right Placeholder -->
        <div class="placeholder-chart">
            Bar chart seluruh kategori nanti
        </div>
    </div>
</div>
@endsection