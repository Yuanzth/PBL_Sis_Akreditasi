@extends('layouts.template')

@push('css')
<style>
    .container-fluid {
        padding: 30px;
    }

    /* Override padding dan margin untuk breadcrumb */
    .content-header {
        padding: 50px 50 !important;
        margin-bottom: 0px !important;
    }

    .content-header .container-fluid {
        padding: 20px 20 !important;
    }

    .content-header .row.mb-2 {
        margin-bottom: 0px !important;
    }

    .welcome-section {
        margin-bottom: 20px;
        background: linear-gradient(135deg, #e0eafc, #cfdef3);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .welcome-section h1 {
        color: #333;
        font-size: 28px;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .welcome-section p {
        color: #555;
        font-size: 16px;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .stats-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        transition: transform 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 180px; /* Meningkatkan tinggi agar konten tidak terpotong */
        overflow: hidden; /* Memastikan konten tidak meluber */
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card .icon {
        font-size: 30px;
        color: #fff;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 15px; /* Jarak lebih besar untuk keseimbangan */
    }

    .card.submitted .icon {
        background-color: #dc3545;
    }

    .card.valid .icon {
        background-color: #28a745;
    }

    .card.rejected .icon {
        background-color: #6f42c1;
    }

    .card.on-progress .icon {
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
        margin: 0;
        line-height: 1.2; /* Memastikan teks tidak terlalu rapat */
    }

    .chart-container {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        height: 100%;
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
        flex: 1;
        max-height: 350px;
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .chart-container {
            height: 300px;
        }

        .chart-container canvas {
            max-height: 250px;
        }

        .card {
            height: 150px; /* Mengurangi tinggi pada layar kecil */
        }
    }
</style>
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Pie Chart untuk Status Kriteria
        const ctxPie = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Submitted', 'Validasi Tahap Satu', 'Validasi Tahap Dua', 'On Progress'],
                datasets: [{
                    label: 'Status Kriteria',
                    data: [@json($statusCounts['submitted']), @json($statusCounts['tahap_satu']), @json($statusCounts['tahap_dua']), @json($statusCounts['on_progress'])],
                    backgroundColor: [
                        '#dc3545', // Submitted
                        '#36A2EB', // Validasi Tahap Satu
                        '#4BC0C0', // Validasi Tahap Dua
                        '#fd7e14'  // On Progress
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
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1>Selamat Datang, {{ $user->name }}</h1>
        <p>Manajemen validasi tahap satu untuk akreditasi SIB.</p>
    </div>

    <!-- Dashboard Grid with Stats and Chart -->
    <div class="dashboard-grid">
        <div class="stats-container">
            <div class="card submitted">
                <div class="icon"><i class="fas fa-paper-plane"></i></div>
                <h3>{{ $stats['submitted'] }}</h3>
                <p>Kriteria Disubmit</p>
            </div>
            <div class="card valid">
                <div class="icon"><i class="fas fa-check-circle"></i></div>
                <h3>{{ $stats['valid'] }}</h3>
                <p>Kriteria Valid</p>
            </div>
            <div class="card rejected">
                <div class="icon"><i class="fas fa-times-circle"></i></div>
                <h3>{{ $stats['rejected'] }}</h3>
                <p>Kriteria Ditolak</p>
            </div>
            <div class="card on-progress">
                <div class="icon"><i class="fas fa-spinner"></i></div>
                <h3>{{ $stats['on_progress'] }}</h3>
                <p>Kriteria On Progress</p>
            </div>
        </div>
        <div class="chart-container">
            <h4>Status Kriteria</h4>
            <p>Lihat distribusi status validasi kriteria Anda.</p>
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>
@endsection