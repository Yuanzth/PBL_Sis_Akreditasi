@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Validasi Tahap Dua</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                    <option value="On Progress">On Progress</option>
                </select>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_validasi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Tanggal Submit</th>
                    <th>Status Selesai</th>
                    <th>Status Validasi</th>
                    <th>Tanggal Validasi</th>
                    <th>Divalidasi Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('css')
<style>
    .status-valid {
        color: #28a745;
        font-weight: bold;
    }
    .status-onkjm {
        color: #7559e4;
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
    .btn-active {
        background-color: #007bff !important;
        color: #fff !important;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5); /* Efek menyala */
        transition: all 0.3s ease;
    }
    .btn-active:hover {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.7);
    }
    .btn-disabled {
        background-color: #6c757d !important;
        color: #ccc !important;
        cursor: not-allowed;
        opacity: 0.6;
    }
    .btn-validated {
        background-color: #17a2b8 !important;
        color: #fff !important;
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() {
        var dataValidasi = $('#table_validasi').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ route('validasi.tahap.dua.list') }}",
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
                },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [
                {
                    targets: [3, 4, 7],
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
            dataValidasi.ajax.reload();
        });
    });

    function showNotSubmittedAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Kriteria ini belum siap untuk divalidasi pada tahap dua',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    }
</script>
@endpush