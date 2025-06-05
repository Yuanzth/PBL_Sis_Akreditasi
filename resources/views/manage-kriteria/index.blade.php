@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Kelola Kriteria</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Tabel Kriteria -->
        <table class="table table-bordered table-striped table-hover table-sm" id="kriteriaTable" style="width: 100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kriteria as $item)
                    <tr>
                        <td></td>
                        <td>{{ $item->nama_kriteria }}</td>
                        <td>{{ $item->level->level_nama }}</td>
                        <td>
                            <button class="btn btn-info btn-sm btn-detail" data-id="{{ $item->id_kriteria }}"><i class="fas fa-eye"></i> Detail</button>
                            <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $item->id_kriteria }}"><i class="fas fa-edit"></i> Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Kriteria -->
<div class="modal fade" id="detailKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="detailKriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kriteria</label>
                    <input type="text" id="detailNamaKriteria" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <input type="text" id="detailLevel" class="form-control" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Kriteria -->
<div class="modal fade" id="editKriteriaModal" tabindex="-1" role="dialog" aria-labelledby="editKriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kriteria</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
            </div>
            <div class="modal-body">
                <form id="editKriteriaForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_kriteria" id="editKriteriaId">
                    <div class="form-group">
                        <label>Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" id="editNamaKriteria" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button class="btn btn-primary" id="submitEditKriteriaForm">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .card {
            position: relative;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: rgb(11, 107, 79);
            color: white;
            font-weight: 600;
        }

        .card-title {
            margin-bottom: 0;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-header {
            background-color: rgb(11, 107, 79);
            color: white;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-info, .btn-warning {
            margin-right: 5px;
        }

        .btn-detail i, .btn-edit i {
            margin-right: 5px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
    $(document).ready(function () {
        var table = $('#kriteriaTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Cari...",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                infoEmpty: "Tidak ada data tersedia",
                zeroRecords: "Tidak ditemukan data yang cocok",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                },
            },
            columnDefs: [
                {
                    targets: 0,
                    data: null,
                    className: "text-center",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    targets: -1,
                    orderable: false,
                    searchable: false
                }
            ],
            dom: '<"row mb-2"<"col-sm-6"l><"col-sm-6 d-flex justify-content-end align-items-center"f>>' +
                'rtip',
        });

        // Tambah label "Cari:"
        $('#kriteriaTable_filter label').contents().filter(function () {
            return this.nodeType === 3;
        }).wrap('<span class="mr-2 font-weight-bold"/>');

        // Detail kriteria
        $(document).on('click', '.btn-detail', function () {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route("kriteria.show", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function (response) {
                    $('#detailNamaKriteria').val(response.nama_kriteria);
                    $('#detailLevel').val(response.level_nama);
                    $('#detailKriteriaModal').modal('show');
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.error || 'Terjadi kesalahan saat mengambil data',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        // Edit kriteria
        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            $.ajax({
                url: '{{ route("kriteria.show", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'GET',
                success: function (response) {
                    $('#editKriteriaId').val(response.id_kriteria);
                    $('#editNamaKriteria').val(response.nama_kriteria);
                    $('#editKriteriaModal').modal('show');
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.error || 'Terjadi kesalahan saat mengambil data',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        // Submit form edit kriteria
        $('#submitEditKriteriaForm').click(function (e) {
            e.preventDefault();
            let id = $('#editKriteriaId').val();
            let formData = new FormData($('#editKriteriaForm')[0]);
            $.ajax({
                url: '{{ route("kriteria.update", ["id" => ":id"]) }}'.replace(':id', id),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function (response) {
                    $('#editKriteriaModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message || 'Data berhasil diperbarui',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    });
                    table.clear().draw();
                    $.ajax({
                        url: '{{ route("kriteria.manage") }}',
                        type: 'GET',
                        success: function () {
                            location.reload();
                        }
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON?.errors || { general: ['Terjadi kesalahan saat menyimpan data'] };
                    let errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += value + '<br>';
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        html: errorMessage,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        // Hapus alert error saat modal dibuka ulang
        $('#detailKriteriaModal, #editKriteriaModal').on('show.bs.modal', function () {
            $('.modal-body .alert').remove();
        });
    });
</script>
@endpush