@extends('layouts.template')

@push('css')
<style>
    .container-fluid {
        padding: 20px;
    }
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .header-section .date-time {
        font-size: 14px;
        color: #555;
    }
    .header-section .logout-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #dc3545;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }
    .header-section .logout-btn:hover {
        background-color: #c82333;
    }
    .welcome-section {
        margin-bottom: 20px;
        background: #f2f2f2;
    }
    .welcome-section h1 {
        color: #333;
        font-size: 24px;
        margin-bottom: 5px;
    }
    .welcome-section p {
        color: #555;
        font-size: 14px;
    }
    .stats-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }
    .card {
        flex: 1;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
        text-align: center;
        position: relative;
    }
    .card .icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 24px;
        color: #fff;
    }
    .card.anggota .icon {
        background-color: #dc3545;
    }
    .card.buku .icon {
        background-color: #28a745;
    }
    .card.transaksi .icon {
        background-color: #6f42c1;
    }
    .card.user .icon {
        background-color: #fd7e14;
    }
    .card h3 {
        font-size: 24px;
        margin-bottom: 5px;
        color: #333;
    }
    .card p {
        font-size: 14px;
        color: #555;
    }
    .content-section {
        display: flex;
        gap: 20px;
    }
    .data-table, .intro-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
    }
    .data-table {
        flex: 2;
    }
    .data-table h2 {
        font-size: 18px;
        color: #333;
        margin-bottom: 15px;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .table th {
        background-color: #f8f9fa;
        color: #333;
        font-size: 14px;
    }
    .table td {
        font-size: 14px;
        color: #555;
    }
    .status-selesai {
        color: #28a745;
        font-weight: bold;
    }
    .intro-section {
        flex: 1;
        background: url('https://via.placeholder.com/300x200') no-repeat center center;
        background-size: cover;
        position: relative;
        color: #fff;
        padding: 20px;
        border-radius: 8px;
    }
    .intro-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 8px;
    }
    .intro-section h2 {
        font-size: 18px;
        position: relative;
        z-index: 1;
        margin-bottom: 10px;
    }
    .intro-section p {
        font-size: 14px;
        position: relative;
        z-index: 1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header with Date and Logout -->
    <div class="header-section">
        
    </div>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1>KPS/Kajur</h1>
        <p>Selamat Datang di Sistem Akreditasi SIB</p>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-cards">
        <div class="card anggota">
            <div class="icon">📋</div>
            <h3>6</h3>
            <p>Kriteria Disubmit</p>
        </div>
        <div class="card buku">
            <div class="icon">📖</div>
            <h3>4</h3>
            <p>Kriteria Valid</p>
        </div>
        <div class="card transaksi">
            <div class="icon">🔄</div>
            <h3>3</h3>
            <p>Kriteria Ditolak</p>
        </div>
        <div class="card user">
            <div class="icon">👤</div>
            <h3>2</h3>
            <p>Kriteria On Progress</p>
        </div>
    </div>

    
@endsection