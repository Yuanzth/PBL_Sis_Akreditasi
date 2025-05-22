@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Kriteria 1</h3>
        <div class="card-tools">
            <!-- Add buttons as needed, e.g., for export or adding data -->
            <button onclick="modalAction('{{ url('/kriteria/create_ajax/') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_kriteria">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Kategori Kriteria</th>
                    <th>Nama Data</th>
                    <th>Tanggal Upload</th>
                    <th>URL Data Pendukung</th>
                    <th>Status Validasi</th>
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
    .btn-file {
        padding: 5px 10px;
        background-color: #28a745;
        color: #fff;
        text-decoration: none;
        border-radius: 3px;
    }
    .btn-file:hover {
        background-color: #218838;
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
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function() {
        var dataKriteria = $('#table_kriteria').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('kriteria/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.kriteria_id = $('#kriteria_id').val();
                }
            },
            columns: [{
                // No (Row Index)
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            }, {
                // ID
                data: "id",
                className: "",
                orderable: true,
                searchable: true
            }, {
                // Kategori Kriteria (Hardcoded as "Penetapan" per the image)
                data: "kategori_kriteria",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return "Penetapan"; // Adjust if this is dynamic in your database
                }
            }, {
                // Nama Data (from kriteria table)
                data: "nama_kriteria",
                className: "",
                orderable: true,
                searchable: true
            }, {
                // Tanggal Upload (from validasi table)
                data: "tanggal_submit",
                className: "",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return data ? data : '-';
                }
            }, {
                // URL Data Pendukung (from validasi table)
                data: "status_submit",
                className: "",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<a href="' + data + '" target="_blank" class="btn-file">Lihat File</a>';
                    }
                    return '-';
                }
            }, {
                // Status Validasi (from validasi table)
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
                // Aksi
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }]
        });

        $('#kriteria_id').on('change', function() {
            dataKriteria.ajax.reload();
        });
    });
</script>
@endpush