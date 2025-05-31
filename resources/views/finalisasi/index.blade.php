@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Finalisasi Dokumen</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                @if (session('document_id'))
                    <a href="{{ route('finalisasi.showFinal', session('document_id')) }}" class="btn btn-sm btn-info mt-2">Lihat Dokumen</a>
                @endif
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="filter_status">Status Validasi</label>
                <select id="filter_status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Valid">Valid</option>
                    <option value="Ditolak">Ditolak</option>
                    <option value="Belum Divalidasi">Belum Divalidasi</option>
                </select>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_finalisasi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Tanggal Submit</th>
                    <th>Status Selesai</th>
                    <th>Status Validasi</th>
                    <th>Tanggal Validasi</th>
                    <th>Divalidasi Oleh</th>
                </tr>
            </thead>
        </table>

        <!-- Tombol Ekspor di luar tabel -->
        <div class="d-flex justify-content-end mt-3">
            <button id="export-btn" class="btn btn-primary" @if($finalDocument) disabled @endif>
                Ekspor Dokumen
            </button>
        </div>

        <!-- Kotak Dokumen Final -->
        @if ($finalDocument)
            <div class="mt-4">
                <h4>Dokumen Final</h4>
                <div class="card">
                    <div class="card-body">
                        <p><strong>Nama File:</strong> {{ basename($finalDocument->final_document) }}</p>
                        <p><strong>Diekspor Oleh:</strong> {{ $finalDocument->user ? $finalDocument->user->name : '-' }}</p>
                        <a href="{{ route('finalisasi.showFinal', $finalDocument->id_final_document) }}" class="btn btn-info">Lihat Dokumen</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('css')
<style>
    .status-valid {
        color: #28a745;
        font-weight: bold;
    }
    .status-rejected {
        color: #dc3545;
        font-weight: bold;
    }
    .status-onprogress {
        color: #fd7e14;
        font-weight: bold;
    }
    .badge-exclamation {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 15px;
        height: 15px;
        background-color: #ff4444; /* Warna merah untuk badge */
        border-radius: 50%; /* Membuat bentuk lingkaran */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #fff;
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        var dataFinalisasi = $('#table_finalisasi').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ route('finalisasi.list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d._token = '{{ csrf_token() }}';
                    d.status_validasi = $('#filter_status').val();
                }
            },
            columns: [
                {
                    data: null,
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nama_kriteria",
                    className: "",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        return data ? data : '-';
                    }
                },
                {
                    data: "tanggal_submit",
                    className: "",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        return data ? data : '-';
                    }
                },
                {
                    data: "status_selesai",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "status_validasi",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "tanggal_validasi",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "divalidasi_oleh",
                    className: "",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        return data ? data : '-';
                    }
                }
            ],
            columnDefs: [
                {
                    targets: [3, 4],
                    render: function(data, type, row) {
                        return type === 'display' ? data : data.replace(/<[^>]+>/g, '');
                    }
                }
            ],
            language: {
                emptyTable: "Tidak ada data yang tersedia di tabel",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                loadingRecords: "Memuat...",
                processing: "Sedang memproses...",
                search: "Cari:",
                zeroRecords: "Tidak ada data yang ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        $('#filter_status').on('change', function() {
            dataFinalisasi.ajax.reload();
        });

        // Aksi tombol Ekspor
        $('#export-btn').on('click', function() {
            Swal.fire({
                title: 'Konfirmasi Ekspor',
                text: 'Apakah Anda yakin ingin mengekspor dokumen final? Proses ini hanya dapat dilakukan satu kali.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ekspor',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("finalisasi.export") }}',
                        method: 'GET',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.success,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonText: 'OK!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = response.download_url; // Download dokumen
                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                        window.location.href = '{{ url("finalisasi-dokumen/show") }}/' + response.document_id; // Redirect ke halaman showFinal
                                    }
                                }).then(() => {
                                    // Reload halaman setelah SweetAlert ditutup
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: xhr.responseJSON.error || 'Terjadi kesalahan saat mengekspor dokumen.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush