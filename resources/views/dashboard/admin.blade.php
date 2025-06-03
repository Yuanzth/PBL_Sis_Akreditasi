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

    .chart-container {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        min-height: 500px;
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
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

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#2ecc71',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Bar Chart
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
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1, // Langkah skala hanya dalam angka bulat
                        title: {
                            display: true,
                            text: 'Jumlah Data'
                        },
                        ticks: {
                            precision: 0 // Pastikan tidak ada desimal pada ticks
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Kategori'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
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
        Selamat Datang, Admin!
    </div>

    <!-- Dashboard Layout -->
    <div class="dashboard-grid">
        <!-- Left Grid -->
        <div class="category-grid">
            @foreach ($categoryCounts as $id => $data)
                <div class="info-box {{ $data['class'] }}">
                    <div class="info-box-content">
                        <span class="info-box-text">{{ $data['name'] }}</span>
                        <span class="info-box-number">{{ $data['count'] }}</span>
                    </div>
                    <span class="info-box-icon">
                        <img src="{{ asset('dashboard/icons/icon_' . $data['class'] . '.png') }}" alt="{{ $data['name'] }} Icon">
                    </span>
                </div>
            @endforeach
        </div>

        <!-- Right Bar Chart -->
        <div class="chart-container">
            <canvas id="categoryChart" style="width: 100%; height: 100%;"></canvas>
        </div>
    </div>
</div>
@endsection