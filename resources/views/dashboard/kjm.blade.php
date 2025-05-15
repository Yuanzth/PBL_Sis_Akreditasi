@extends('layouts.template')

@push('css')
<style>
.sidebar .nav-link.active {
    background-color: #0abf78;
    color: white;
}

.sidebar .nav-link i {
    color: white;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <h3 class="card-title">Selamat Datang KJM</h3>
        </div>
        <div class="card-body">
            <p>Ini adalah halaman dashboard khusus untuk pengguna dengan role <strong>KJM</strong>.</p>
            <ul class="list-unstyled">
                <li><i class="fas fa-eye"></i> Melihat data akreditasi</li>
                <li><i class="fas fa-check-square"></i> Memverifikasi dokumen</li>
                <li><i class="fas fa-chart-line"></i> Monitoring progres setiap unit</li>
            </ul>
        </div>
    </div>
</div>
@endsection