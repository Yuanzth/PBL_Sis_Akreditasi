@extends('layouts.template')

@push('css')
<style>
    .container-fluid {
        padding: 30px;
    }

    .welcome-card {
        background: linear-gradient(135deg, #4b6cb7, #182848);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
    }

    .welcome-card h3 {
        margin: 0 15px 0 0;
        font-size: 24px;
        font-weight: 600;
    }

    .welcome-card i {
        font-size: 30px;
        margin-right: 25px; /* Menambah jarak antara ikon dan teks */
    }

    .welcome-card p {
        margin: 0;
        font-size: 16px;
    }

    .nav-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .nav-card {
        background: linear-gradient(135deg, #6b48b7, #2a1848);
        border-radius: 12px;
        padding: 15px;
        color: #ffffff;
        text-align: center;
        text-decoration: none;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .nav-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .nav-card i {
        font-size: 32px;
        margin-bottom: 8px;
    }

    .nav-card span {
        font-size: 16px;
        font-weight: 500;
        line-height: 1.2;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); /* Membuat dua kolom untuk bar dan pie chart */
        gap: 20px;
    }

    .chart-container {
        background: #ffffff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        position: relative;
        height: 350px; /* Mengurangi tinggi untuk proporsi yang lebih baik */
        display: flex;
        flex-direction: column;
    }

    .chart-container h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .chart-container p {
        font-size: 14px;
        color: #666;
        margin-bottom: 15px;
    }

    .chart-container canvas {
        flex: 1; /* Memastikan canvas mengambil sisa ruang */
        max-height: 250px; /* Membatasi tinggi canvas agar tidak meluber */
    }

    /* Media query untuk layar kecil */
    @media (max-width: 576px) {
        .nav-options {
            grid-template-columns: 1fr;
        }

        .nav-card {
            height: 100px;
        }

        .nav-card i {
            font-size: 28px;
        }

        .nav-card span {
            font-size: 14px;
        }

        .dashboard-grid {
            grid-template-columns: 1fr; /* Satu kolom pada layar kecil */
        }

        .chart-container {
            height: 300px; /* Mengurangi tinggi pada layar kecil */
        }

        .chart-container canvas {
            max-height: 200px;
        }
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Bar Chart untuk Jumlah Data Pendukung
        const ctxBar = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($categories),
                datasets: [{
                    label: 'Jumlah Data Pendukung',
                    data: @json($counts),
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const { ctx, chartArea } = chart;
                        if (!chartArea) return;
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(35, 195, 216, 0.8)');
                        gradient.addColorStop(1, 'rgba(27, 117, 187, 0.8)');
                        return gradient;
                    },
                    borderColor: ['#1A9BAE', '#1486C2', '#5E63C2', '#3A5E94', '#364790'],
                    borderWidth: 2,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1,
                        title: { display: true, text: 'Jumlah Data', font: { size: 14 } },
                        ticks: { precision: 0, font: { size: 12 } }
                    },
                    x: {
                        title: { display: true, text: 'Kategori', font: { size: 14 } },
                        ticks: { font: { size: 12 } }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top', labels: { font: { size: 14 } } },
                    tooltip: { enabled: true, backgroundColor: '#333', titleFont: { size: 14 }, bodyFont: { size: 12 } }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });

        // Pie Chart untuk Status Kriteria
        const ctxPie = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Submitted', 'On Progress Admin', 'Validasi Tahap Satu', 'Validasi Tahap Dua'],
                datasets: [{
                    label: 'Status Kriteria',
                    data: [@json($statusCounts['submitted']), @json($statusCounts['on_progress']), @json($statusCounts['tahap_satu']), @json($statusCounts['tahap_dua'])],
                    backgroundColor: [
                        '#23C3D8', // Submitted
                        '#FF6384', // On Progress
                        '#36A2EB', // Validasi Tahap Satu
                        '#4BC0C0'  // Validasi Tahap Dua
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true, position: 'top', labels: { font: { size: 14 } } },
                    tooltip: { enabled: true, backgroundColor: '#333', titleFont: { size: 14 }, bodyFont: { size: 12 } }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuad'
                }
            }
        });
    });
</script>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Welcome Message -->
    <div class="welcome-card">
        <i class="fas fa-user-shield" padding-right='3px'></i>
        <div>
            <h3>Selamat Datang, {{ $user->name }} (SuperAdmin)</h3>
            <p>Anda memiliki akses penuh untuk mengelola sistem. Pilih opsi di bawah ini:</p>
        </div>
    </div>

    <!-- Navigasi Opsi -->
    <div class="nav-options">
        <a href="{{ route('users.manage') }}" class="nav-card">
            <i class="fas fa-users"></i>
            <span>Kelola Pengguna</span>
        </a>
        <a href="{{ route('kriteria.manage') }}" class="nav-card">
            <i class="fas fa-list"></i>
            <span>Kelola Kriteria</span>
        </a>
    </div>

    <!-- Ringkasan Data -->
    <div class="dashboard-grid">
        <div class="chart-container">
            <h4>Ringkasan Data Pendukung (Semua Kriteria)</h4>
            <p>Lihat distribusi data pendukung untuk semua kriteria secara keseluruhan.</p>
            <canvas id="categoryChart"></canvas>
        </div>
        <div class="chart-container">
            <h4>Status Kriteria</h4>
            <p>Lihat status validasi semua kriteria yang dikelola.</p>
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>
@endsection