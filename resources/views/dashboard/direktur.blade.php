@extends('layouts.template')

@push('css')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<style>
/* Hanya untuk isi halaman utama, tidak sidebar */
.dashboard-wrapper {
    font-family: 'Poppins', sans-serif;
    padding: 20px;
    background-color: #f4f6f9;
}

/* Box utama */
.card-box {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

.card-box p {
    font-size: 16px;
    color: #333;
    margin-bottom: 15px;
}

/* Tombol status di bawah card utama */
.status-cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 20px;
}

/* Tampilan setiap card status */
.status-card {
    min-width: 220px;
    padding: 20px;
    border-radius: 12px;
    background-color: white;
    color: #333;
    text-align: center;
    font-weight: 600;
    font-size: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    border: 2px solid transparent;
    transition: transform 0.2s ease;
    cursor: default;
}

.status-card:hover {
    transform: translateY(-2px);
}

.status-card .subtext {
    font-size: 14px;
    font-weight: 400;
    color: #555;
    margin-top: 6px;
}

/* Warna border sesuai status */
.border-submitted {
    border-color: #3f51b5; /* biru */
}

.border-validation {
    border-color: #f39c12; /* oranye */
}

.border-kriteria {
    border-color: #2ecc71; /* hijau */
}
</style>
@endpush

@section('content')
<div class="dashboard-wrapper">

    {{-- Card utama dengan teks deskripsi --}}
    <div class="card-box">
        <p>Selamat datang di Sistem Akreditasi Program Studi Sistem Informasi Bisnis.</p>
        <p>Sejauh ini sudah ada <strong>5</strong> Kriteria yang di-submit dan <strong>3</strong> menunggu validasi.</p>
        <p>Direktur melakukan validasi. Jika semua 9 kriteria divalidasi, tombol ekspor dokumen final akan muncul. Jika ada revisi, kriteria dikembalikan ke admin dengan komentar.</p>
    </div>

    {{-- Tombol-tombol status di bawah card utama --}}
    <div class="status-cards">
        <div class="status-card border-submitted">
            Submitted
            <div class="subtext">Total: 5</div>
        </div>
        <div class="status-card border-validation">
            On Validation KPS/Kajur
            <div class="subtext">Menunggu validasi: 3</div>
        </div>
        <div class="status-card border-kriteria">
            Validasi Kriteria
            <div class="subtext">Mulai validasi sekarang</div>
        </div>
    </div>

</div>
@endsection
