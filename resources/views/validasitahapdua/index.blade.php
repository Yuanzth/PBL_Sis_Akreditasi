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
        <table class="table table-bordered table-striped table-hover table-sm" id="table_validasi">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Tanggal Submit</th>
                    <th>Tanggal Validasi</th>
                    <th>Status Validasi</th>
                    <th>Divalidasi Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal untuk Show Detail -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"></div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_validasi').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ route('validasi.tahap.dua.list') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                },
                error: function(xhr, error, thrown) {
                    console.log('DataTables error:', xhr.responseText);
                    alert('Terjadi kesalahan saat memuat data: ' + xhr.status + ' - ' + xhr.statusText);
                }
            },
            columns: [
                { data: null, className: "text-center", orderable: false, searchable: false, render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                { data: "nama_kriteria" },
                { data: "tanggal_submit" },
                { data: "tanggal_validasi" },
                { data: "status_validasi", className: "text-center" },
                { data: "divalidasi_oleh" },
                { data: "aksi", className: "text-center", orderable: false, searchable: false }
            ],
            error: function(xhr, error, thrown) {
                console.log('DataTables error:', xhr.responseText);
            }
        });
    });

    function showDetail(url) {
        $.get(url, function(data) {
            $('#myModal').html(data).modal('show');
        });
    }
</script>
@endpush
@endsection