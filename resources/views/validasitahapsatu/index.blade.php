@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Validasi Tahap Satu</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <!-- Filter and Search Section -->
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
            <div class="col-md-3">
                <label for="search_global">Pencarian</label>
                <input type="text" id="search_global" class="form-control" placeholder="Cari...">
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_validasi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Tanggal Submit</th>
                    <th>Status Validasi</th>
                    <th>Divalidasi Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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
    .btn-detail {
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 3px;
    }
    .btn-detail:hover {
        background-color: #0056b3;
    }
</style>
@endpush

@push('js')
<script>
    function modalAction(url = '') {
        if (url) {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
    }

    function showDetail(url) {
        modalAction(url);
    }

    function approveAction(url) {
        if (confirm('Apakah Anda yakin ingin menyetujui data ini?')) {
            $.post(url, {_token: '{{ csrf_token() }}'}, function(data) {
                if (data.status) {
                    $('#table_validasi').DataTable().ajax.reload();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            });
        }
    }

    function rejectAction(url) {
        if (confirm('Apakah Anda yakin ingin menolak data ini?')) {
            $.post(url, {_token: '{{ csrf_token() }}'}, function(data) {
                if (data.status) {
                    $('#table_validasi').DataTable().ajax.reload();
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            });
        }
    }

    function notesAction(url) {
        modalAction(url);
    }

    $(document).ready(function() {
        var dataValidasi = $('#table_validasi').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('validasi-tahap-satu/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.nama_kriteria = $('#filter_kriteria').val();
                    d.status_validasi = $('#filter_status').val();
                    d.divalidasi_oleh = $('#filter_user').val();
                    d.search_global = $('#search_global').val();
                }
            },
            columns: [{
                // No (Row Index)
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            }, {
                // Nama Kriteria (from m_kriteria)
                data: "nama_kriteria",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return data ? data : '-';
                }
            }, {
                // Tanggal Submit (from t_validasi)
                data: "tanggal_submit",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return data ? data : '-';
                }
            }, {
                // Status Validasi (from t_validasi)
                data: "status_validasi",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    if (data === 'Valid') {
                        return '<span class="status-valid">' + data + '</span>';
                    } else if (data === 'Ditolak') {
                        return '<span class="status-rejected">' + data + '</span>';
                    } else if (data === 'On Progress') {
                        return '<span class="status-onprogress">' + data + '</span>';
                    }
                    return '-';
                }
            }, {
                // Divalidasi Oleh (from m_user via id_user in t_validasi)
                data: "divalidasi_oleh",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return data ? data : '-';
                }
            }, {
                // Aksi
                data: "aksi",
                className: "text-center",
                orderable: false,
                searchable: false
            }],
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

        // Handle filter and search events
        $('#filter_kriteria, #filter_status, #filter_user').on('change', function() {
            dataValidasi.ajax.reload();
        });

        $('#search_global').on('keyup', function() {
            dataValidasi.ajax.reload();
        });
    });
</script>
@endpush