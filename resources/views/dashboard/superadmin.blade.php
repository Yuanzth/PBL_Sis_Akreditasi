@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="welcome-card">
        <h3>Selamat Datang, {{ $user->name }} (SuperAdmin)</h3>
        <p>Anda memiliki akses penuh untuk mengelola sistem. Pilih opsi di bawah ini:</p>
        <ul>
            <li><a href="{{ route('users.manage') }}">Kelola Pengguna</a></li>
            <li><a href="{{ route('kriteria.manage') }}">Kelola Kriteria</a></li>
        </ul>
    </div>

    <!-- Menampilkan ringkasan semua kriteria (contoh sederhana) -->
    <div class="dashboard-grid">
        <div class="chart-container" style="position: relative; height: 400px; width: 100%; max-width: 800px;">
            <h4>Ringkasan Data Pendukung (Semua Kriteria)</h4>
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($categories),
                datasets: [{
                    label: 'Jumlah Data Pendukung',
                    data: @json($counts),
                    backgroundColor: ['#23C3D8', '#1CA7EC', '#787FF6', '#4B77BE', '#4555BA'],
                    borderColor: ['#1A9BAE', '#1486C2', '#5E63C2', '#3A5E94', '#364790'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Memungkinkan kontrol manual atas ukuran
                aspectRatio: 1.5, // Rasio aspek untuk menjaga proporsi
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        title: { display: true, text: 'Jumlah Data' },
                        ticks: { precision: 0 }
                    },
                    x: {
                        title: { display: true, text: 'Kategori' }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: { enabled: true }
                },
                animation: {
                    duration: 0 // Nonaktifkan animasi untuk mengurangi lag
                }
            }
        });
    });
</script>
@endpush
@endsection