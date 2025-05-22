@extends('layouts.template')

@push('css')
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.1.0/ckeditor5.css">
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
<style>
    .container-fluid {
        padding: 20px;
    }
    .category-section {
        margin-bottom: 30px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px;
        background: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .category-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 5px;
    }
    .data-pendukung-cards {
        display: flex;
        flex-wrap: wrap;
    }
    .data-pendukung-card {
        display: inline-block;
        margin: 10px;
        padding: 15px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        width: 200px;
        text-align: center;
    }
    .data-pendukung-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    .data-pendukung-card .name {
        font-weight: 500;
        color: #2980b9;
        margin-bottom: 5px;
    }
    .data-pendukung-form {
        display: none;
        margin-top: 15px;
        background: #fff;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .form-row {
        display: flex;
        gap: 20px;
        margin-bottom: 15px;
    }
    .form-group {
        flex: 1;
    }
    .form-control, .ck-editor__editable {
        border-radius: 5px;
        min-height: 100px;
        border: 1px solid #ccc;
    }
    .dropzone {
        border: 2px dashed #3498db;
        border-radius: 5px;
        background: #ecf0f1;
        padding: 20px;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2980b9;
    }
    .dz-preview {
        margin: 5px;
    }
    .action-buttons {
        margin-top: 20px;
    }
    .btn {
        margin-right: 10px;
        border-radius: 5px;
        transition: background 0.2s;
    }
    .btn-primary { background: #3498db; border-color: #2980b9; }
    .btn-primary:hover { background: #2980b9; }
    .btn-success { background: #2ecc71; border-color: #27ae60; }
    .btn-success:hover { background: #27ae60; }
    .btn-danger { background: #e74c3c; border-color: #c0392b; }
    .btn-danger:hover { background: #c0392b; }
    .btn-warning { background: #f1c40f; border-color: #f39c12; }
    .btn-warning:hover { background: #f39c12; }
</style>
@endpush

@push('js')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script>
    Dropzone.autoDiscover = false;

    document.addEventListener('DOMContentLoaded', function () {
        const { ClassicEditor, Essentials, Bold, Italic, Font, Paragraph, AutoLink, Link } = CKEDITOR;

        const editors = new Map();
        const dropzones = new Map();

        function initializeCKEditor(element, formId) {
            if (editors.has(formId)) {
                editors.get(formId).destroy().catch(error => console.error('Error destroying CKEditor:', error));
                editors.delete(formId);
            }

            return ClassicEditor
                .create(element, {
                    licenseKey: 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NDkwODE1OTksImp0aSI6Ijc2MDllYTkwLWY3MmQtNGUyMi1hZGFjLTI4ZGZkMWU3ZWE3NCIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6IjhkMTQwYzA1In0.vQYkzmIZNL2X3im8qQowY6Yz4wr4Czy2qSHbyXjSV9A08uEkDwCEaJcrqsJ49ELKtKiQfPLI4t5Ng5FiINsyNA',
                    plugins: [Link, AutoLink, Essentials, Bold, Italic, Font, Paragraph],
                    toolbar: ['undo', 'redo', '|', 'bold', 'italic', 'link', '|', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor']
                })
                .then(editor => {
                    editors.set(formId, editor);
                    return editor;
                })
                .catch(error => console.error('CKEditor error:', error));
        }

        function initializeDropzone(element, formId, categoryIndex, dataIndex, dataId = null) {
            if (dropzones.has(formId)) {
                dropzones.get(formId).destroy();
                dropzones.delete(formId);
            }

            const dropzone = new Dropzone(element, {
                url: "{{ route('kriteria.save', ['id' => $kriteria->id_kriteria]) }}",
                paramName: `data_pendukung[${categoryIndex}][${dataIndex}][gambar]`,
                maxFilesize: 2,
                acceptedFiles: 'image/jpeg,image/png,image/jpg',
                addRemoveLinks: true,
                dictDefaultMessage: 'Seret gambar atau klik untuk upload',
                autoProcessQueue: false,
                init: function () {
                    this.on('addedfile', function (file) {
                        if (file.previewElement) {
                            file.previewElement.addEventListener('load', function () {
                                file.previewElement.style.display = 'block';
                            });
                        }
                    });
                    this.on('sending', function (file, xhr, formData) {
                        formData.append('_token', '{{ csrf_token() }}');
                        const inputs = document.getElementById(formId).querySelectorAll('input:not([type="file"]), textarea');
                        inputs.forEach(input => formData.append(input.name, input.value));
                        if (dataId) formData.append('id_data_pendukung', dataId);
                    });
                    this.on('success', function (file, response) {
                        // Handle success
                    });
                }
            });
            dropzones.set(formId, dropzone);
            return dropzone;
        }

        function resetAddForm(form) {
            const formId = form.id;
            if (editors.has(formId)) {
                editors.get(formId).destroy().catch(error => console.error('Error destroying CKEditor:', error));
                editors.delete(formId);
            }
            if (dropzones.has(formId)) {
                dropzones.get(formId).destroy();
                dropzones.delete(formId);
            }
            form.querySelectorAll('input:not([type="hidden"]), textarea').forEach(input => {
                input.value = '';
            });
            form.style.display = 'none';
        }

        function resetEditForm(form) {
            const formId = form.id;
            if (editors.has(formId)) {
                editors.get(formId).destroy().catch(error => console.error('Error destroying CKEditor:', error));
                editors.delete(formId);
            }
            if (dropzones.has(formId)) {
                dropzones.get(formId).destroy();
                dropzones.delete(formId);
            }
            form.style.display = 'none';
        }

        // Tampilkan form tambah
        document.querySelectorAll('.add-data-btn').forEach(button => {
            button.addEventListener('click', function () {
                const categoryIndex = this.dataset.category;
                const form = document.getElementById(`add-form-${categoryIndex}`);
                const editForms = document.querySelectorAll(`.edit-form-${categoryIndex}`);
                editForms.forEach(f => resetEditForm(f));
                form.style.display = 'block';
                const ckeditor = form.querySelector('.ckeditor');
                initializeCKEditor(ckeditor, `add-form-${categoryIndex}`);
                const dropzone = form.querySelector('.dropzone');
                initializeDropzone(dropzone, `add-form-${categoryIndex}`, categoryIndex, 'new');
            });
        });

        // Tampilkan form edit
        document.addEventListener('click', function (e) {
            const editBtn = e.target.closest('.edit-data-btn');
            if (editBtn) {
                const categoryIndex = editBtn.dataset.category;
                const dataIndex = editBtn.dataset.index;
                const form = document.getElementById(`edit-form-${categoryIndex}-${dataIndex}`);
                const addForm = document.getElementById(`add-form-${categoryIndex}`);
                const otherEditForms = document.querySelectorAll(`.edit-form-${categoryIndex}:not(#edit-form-${categoryIndex}-${dataIndex})`);
                resetAddForm(addForm);
                otherEditForms.forEach(f => resetEditForm(f));
                form.style.display = 'block';
                const ckeditor = form.querySelector('.ckeditor');
                initializeCKEditor(ckeditor, `edit-form-${categoryIndex}-${dataIndex}`);
                const dropzone = form.querySelector('.dropzone');
                const dataId = form.querySelector('input[name="data_pendukung[' + categoryIndex + '][' + dataIndex + '][id_data_pendukung]"]').value;
                initializeDropzone(dropzone, `edit-form-${categoryIndex}-${dataIndex}`, categoryIndex, dataIndex, dataId);
            }
        });

        // Event listener untuk tombol Save di form
        document.addEventListener('click', function (e) {
            const saveBtn = e.target.closest('.save-btn');
            if (saveBtn) {
                e.preventDefault();
                const form = saveBtn.closest('form');
                const formId = form.id;
                
                // Sinkronkan data CKEditor ke textarea
                const editor = editors.get(formId);
                if (editor) {
                    const textarea = form.querySelector('.ckeditor');
                    textarea.value = editor.getData();
                }

                const formData = new FormData(form);
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('draft', '1');

                // Proses unggahan Dropzone
                const dropzone = dropzones.get(formId);
                if (dropzone && dropzone.files.length > 0) {
                    dropzone.processQueue();
                } else {
                    // Jika tidak ada file, langsung kirim form
                    sendFormData(formData, form);
                }

                // Listener untuk Dropzone setelah semua file diunggah
                if (dropzone) {
                    dropzone.on('queuecomplete', function () {
                        sendFormData(formData, form);
                    });
                }
            }
        });

        function sendFormData(formData, form) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data akan disimpan sebagai draft.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3498db',
                cancelButtonColor: '#e74c3c',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('kriteria.save', ['id' => $kriteria->id_kriteria]) }}",
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            Swal.fire('Sukses!', 'Data berhasil disimpan sebagai draft.', 'success');
                            resetEditForm(form);
                            location.reload(); // Reload halaman untuk menampilkan data baru
                        },
                        error: function (xhr) {
                            Swal.fire('Error!', 'Gagal menyimpan data.', 'error');
                        }
                    });
                }
            });
        }

        // Event listener untuk tombol Delete di form
        document.addEventListener('click', function (e) {
            const deleteBtn = e.target.closest('.delete-btn');
            if (deleteBtn) {
                e.preventDefault();
                const form = deleteBtn.closest('form');
                const dataId = form.querySelector('input[name^="data_pendukung"][name$="[id_data_pendukung]"]').value;
                const url = "{{ route('kriteria.deleteData', ['id' => $kriteria->id_kriteria, 'dataId' => ':dataId']) }}".replace(':dataId', dataId);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#3498db',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_data_pendukung: dataId
                            },
                            success: function (response) {
                                Swal.fire('Sukses!', 'Data berhasil dihapus.', 'success');
                                form.remove();
                                location.reload(); // Reload halaman untuk memperbarui daftar
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                            }
                        });
                    }
                });
            }
        });

        // Event listener untuk tombol Cancel
        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                if (form.classList.contains('add-form')) {
                    resetAddForm(form);
                } else {
                    resetEditForm(form);
                }
                Swal.fire('Dibatalkan', 'Aksi dibatalkan.', 'info');
            });
        });
    });
</script>
@endpush

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('success') }}
        </div>
    @endif

    @foreach ($detailKriteria as $index => $detail)
        <div class="category-section">
            <div class="category-title">{{ $detail->kategori->nama_kategori }}</div>

            <!-- Form tambah data pendukung (tersembunyi) -->
            @if ($kriteria->status_selesai != 'Submitted')
                <form id="add-form-{{ $index }}" class="data-pendukung-form add-form" data-category="{{ $index }}">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Data Pendukung</label>
                            <textarea class="form-control" name="data_pendukung[{{ $index }}][new][nama_data]" rows="2"></textarea>
                            <input type="hidden" name="data_pendukung[{{ $index }}][new][id_detail_kriteria]" value="{{ $detail->id_detail_kriteria }}">
                            <input type="hidden" name="data_pendukung[{{ $index }}][new][index]" value="new">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Data Pendukung</label>
                            <textarea class="form-control ckeditor" name="data_pendukung[{{ $index }}][new][deskripsi_data]"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>URL Data Pendukung</label>
                            <textarea class="form-control" name="data_pendukung[{{ $index }}][new][hyperlink_data]" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Upload Data</label>
                            <div class="dropzone"></div>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button type="button" class="btn btn-primary save-btn">Save</button>
                        <button type="button" class="btn btn-success cancel-btn">Cancel</button>
                        <button type="button" class="btn btn-danger delete-btn" disabled>Delete</button>
                    </div>
                </form>
            @endif

            <!-- Daftar data pendukung yang sudah ada -->
            @if ($detail->dataPendukung->count() > 0)
                <div class="data-pendukung-cards">
                    @foreach ($detail->dataPendukung as $dataIndex => $dataPendukung)
                        <div class="data-pendukung-card">
                            <div class="name">{{ $dataPendukung->nama_data }}</div>
                            @if ($kriteria->status_selesai != 'Submitted')
                                <button class="btn btn-warning edit-data-btn" data-category="{{ $index }}" data-index="{{ $dataIndex }}">Edit</button>
                            @endif
                        </div>
                        <!-- Form edit data pendukung (tersembunyi) -->
                        @if ($kriteria->status_selesai != 'Submitted')
                            <form id="edit-form-{{ $index }}-{{ $dataIndex }}" class="data-pendukung-form edit-form edit-form-{{ $index }}" data-category="{{ $index }}">
                                <input type="hidden" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][id_data_pendukung]" value="{{ $dataPendukung->id_data_pendukung }}">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Nama Data Pendukung</label>
                                        <textarea class="form-control" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][nama_data]" rows="2">{{ $dataPendukung->nama_data }}</textarea>
                                        <input type="hidden" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][id_detail_kriteria]" value="{{ $detail->id_detail_kriteria }}">
                                        <input type="hidden" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][index]" value="{{ $dataIndex }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi Data Pendukung</label>
                                        <textarea class="form-control ckeditor" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][deskripsi_data]">{{ $dataPendukung->deskripsi_data }}</textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>URL Data Pendukung</label>
                                        <textarea class="form-control" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][hyperlink_data]" rows="2">{{ $dataPendukung->hyperlink_data }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Data</label>
                                        <div class="dropzone"></div>
                                    </div>
                                </div>
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-primary save-btn">Save</button>
                                    <button type="button" class="btn btn-success cancel-btn">Cancel</button>
                                    <button type="button" class="btn btn-danger delete-btn">Delete</button>
                                </div>
                            </form>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Tombol tambah data pendukung -->
            @if ($kriteria->status_selesai != 'Submitted')
                <button type="button" class="btn btn-warning add-data-btn" data-category="{{ $index }}">Tambah Data Pendukung</button>
            @endif
        </div>
    @endforeach

    <!-- Komentar Revisi -->
    @if ($komentar->count() > 0)
        <div class="category-section">
            <div class="category-title">Komentar Revisi</div>
            @foreach ($komentar as $komen)
                <div class="komentar-item" style="background: #fff; padding: 10px; border-radius: 5px; margin-bottom: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <p><strong>{{ $komen->user->name }}</strong> ({{ $komen->created_at->format('d M Y H:i') }})</p>
                    <p>{{ $komen->komentar }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Tombol Save dan Submit -->
    @if ($kriteria->status_selesai != 'Submitted')
        <div class="action-buttons">
            <form action="{{ route('kriteria.save', ['id' => $kriteria->id_kriteria]) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="final_save" value="1">
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            <form action="{{ route('kriteria.submit', ['id' => $kriteria->id_kriteria]) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin submit kriteria ini?')">Submit</button>
            </form>
        </div>
    @endif
</div>
@endsection
