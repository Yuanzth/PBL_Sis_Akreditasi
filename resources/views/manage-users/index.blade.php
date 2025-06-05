@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Kelola Pengguna</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- Tabel Pengguna -->
            <table class="table table-bordered table-striped table-hover table-sm" id="usersTable" style="width: 100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->level->level_nama }}</td>
                            <td>
                                <button class="btn btn-info btn-sm btn-detail" data-id="{{ $user->id_user }}"><i class="fas fa-eye"></i> Detail</button>
                                <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $user->id_user }}"><i class="fas fa-edit"></i> Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Pengguna -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna Baru</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm">
                        @csrf
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select name="id_level" class="form-control" required>
                                @foreach (\App\Models\LevelModel::all() as $level)
                                    <option value="{{ $level->id_level }}">{{ $level->level_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" id="submitUserForm">Tambah Pengguna</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pengguna -->
    <div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="detailUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" id="detailUsername" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="detailName" class="form-control" readonly>
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

    <!-- Modal Edit Pengguna -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_user" id="editUserId">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" id="editUsername" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" name="password" id="editPassword" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <select name="id_level" id="editLevelId" class="form-control" required>
                                @foreach (\App\Models\LevelModel::all() as $level)
                                    <option value="{{ $level->id_level }}">{{ $level->level_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" id="submitEditUserForm">Simpan Perubahan</button>
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

        .btn-add-user i, .btn-detail i, .btn-edit i {
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
            var table = $('#usersTable').DataTable({
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
                        next: "Selanjutnya",
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
                        render: function(data, type, row, meta) {
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
                    '<"row mb-3"<"col-sm-12 d-flex justify-content-end" <"#custom-toolbar">>>' +
                    'rtip',
            });

            // Inject tombol Tambah Pengguna
            $('#custom-toolbar').html(`
                <button type="button" class="btn btn-primary btn-add-user w-100" style="max-width: 300px;" data-toggle="modal" data-target="#addUserModal">
                    <i class="nav-icon fas fa-users"></i> Tambah Pengguna
                </button>
            `);

            // Tambah label "Cari:"
            $('#usersTable_filter label').contents().filter(function () {
                return this.nodeType === 3;
            }).wrap('<span class="mr-2 font-weight-bold"/>');

            // Submit form tambah pengguna
            $('#submitUserForm').click(function (e) {
                e.preventDefault();
                let formData = new FormData($('#addUserForm')[0]);
                $.ajax({
                    url: '{{ route("users.create") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('#addUserModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message || 'Data berhasil disimpan',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                        table.row.add([
                            '', // Placeholder for auto-increment number
                            response.user.username,
                            response.user.name,
                            response.user.level_nama,
                            '<button class="btn btn-info btn-sm btn-detail" data-id="' + response.user.id_user + '"><i class="fas fa-eye"></i> Detail</button>' +
                            '<button class="btn btn-warning btn-sm btn-edit" data-id="' + response.user.id_user + '"><i class="fas fa-edit"></i> Edit</button>'
                        ]).draw();
                        $('#addUserForm')[0].reset();
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

            // Detail pengguna
            $(document).on('click', '.btn-detail', function () {
                let id = $(this).data('id');
                $.ajax({
                    url: '{{ route("users.manage") }}/' + id,
                    type: 'GET',
                    success: function (response) {
                        $('#detailUsername').val(response.username);
                        $('#detailName').val(response.name);
                        $('#detailLevel').val(response.level_nama);
                        $('#detailUserModal').modal('show');
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

            // Edit pengguna
            $(document).on('click', '.btn-edit', function () {
                let id = $(this).data('id');
                $.ajax({
                    url: '{{ route("users.manage") }}/' + id,
                    type: 'GET',
                    success: function (response) {
                        $('#editUserId').val(id);
                        $('#editUsername').val(response.username);
                        $('#editName').val(response.name);
                        $('#editLevelId').val(response.id_level);
                        $('#editPassword').val('');
                        $('#editUserModal').modal('show');
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

            // Submit form edit pengguna
            $('#submitEditUserForm').click(function (e) {
                e.preventDefault();
                let id = $('#editUserId').val();
                let formData = new FormData($('#editUserForm')[0]);
                $.ajax({
                    url: '{{ route("users.manage") }}/' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function (response) {
                        $('#editUserModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: response.message || 'Data berhasil diperbarui',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6'
                        });
                        table.clear().draw();
                        $.ajax({
                            url: '{{ route("users.manage") }}',
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
            $('#addUserModal, #editUserModal').on('show.bs.modal', function () {
                $('.modal-body .alert').remove();
            });
        });
    </script>
@endpush