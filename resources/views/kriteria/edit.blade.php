@extends('layouts.template')

@push('css')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.2.0/ckeditor5.css" crossorigin>
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
            width: 100%;
        }

        .data-pendukung-form-add {
            display: none;
            margin-top: 15px;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .form-row {
            display: block;
            margin-bottom: 15px;
        }

        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
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
            width: 100%;
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

        .btn-primary {
            background: #3498db;
            border-color: #2980b9;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-success {
            background: #2ecc71;
            border-color: #27ae60;
        }

        .btn-success:hover {
            background: #27ae60;
        }

        .btn-danger {
            background: #e74c3c;
            border-color: #c0392b;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f1c40f;
            border-color: #f39c12;
        }

        .btn-warning:hover {
            background: #f39c12;
        }

        /* Custom CKEditor Styling */
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;1,400;1,700&display=swap');

        @media print {
            body {
                margin: 0 !important;
            }
        }

        .main-container {
            font-family: 'Lato';
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        .ck-content {
            font-family: 'Lato';
            line-height: 1.6;
            word-break: break-word;
        }

        .editor-container_classic-editor .editor-container__editor {
            min-width: 100%;
            max-width: 100%;
        }
    </style>
@endpush

@push('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/45.2.0/ckeditor5.umd.js" crossorigin></script>
    <script>
        Dropzone.autoDiscover = false;

        document.addEventListener('DOMContentLoaded', function () {
            const editors = new Map();
            const dropzones = new Map();

            document.querySelectorAll('.add-data-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const categoryIndex = this.dataset.category;
                    const form = document.getElementById(`add-form-${categoryIndex}`);
                    const editForms = document.querySelectorAll(`.edit-form-${categoryIndex}`);
                    editForms.forEach(f => resetEditForm(f));
                    form.style.display = 'block';

                    const dropzone = form.querySelector('.dropzone');
                    initializeDropzone(dropzone, `add-form-${categoryIndex}`, categoryIndex, 'new');

                    const ckeditor = form.querySelector('.ckeditor');
                    if (window.CKEDITOR && window.CKEDITOR.ClassicEditor) {
                        initializeCKEditor(ckeditor, `add-form-${categoryIndex}`);
                    } else {
                        console.warn('CKEditor not available. Falling back to textarea.');
                    }
                });
            });

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

                    const dropzone = form.querySelector('.dropzone');
                    const dataId = form.querySelector('input[name="data_pendukung[' + categoryIndex + '][' + dataIndex + '][id_data_pendukung]"]').value;
                    initializeDropzone(dropzone, `edit-form-${categoryIndex}-${dataIndex}`, categoryIndex, dataIndex, dataId);

                    const ckeditor = form.querySelector('.ckeditor');
                    if (window.CKEDITOR && window.CKEDITOR.ClassicEditor) {
                        initializeCKEditor(ckeditor, `edit-form-${categoryIndex}-${dataIndex}`);
                    } else {
                        console.warn('CKEditor not available. Falling back to textarea.');
                    }
                }
            });

            function initializeCKEditor(element, formId) {
                if (!window.CKEDITOR || !window.CKEDITOR.ClassicEditor) {
                    console.error('CKEditor is not loaded.');
                    return Promise.reject('CKEditor not loaded');
                }

                const { ClassicEditor, Autoformat, Autosave, BalloonToolbar, BlockQuote, Bold, Essentials, Heading, Indent, IndentBlock, Italic, Link, List, ListProperties, Paragraph, PasteFromOffice, Subscript, Superscript, Table, TableCaption, TableCellProperties, TableColumnResize, TableLayout, TableProperties, TableToolbar, TextTransformation, TodoList, Underline } = window.CKEDITOR;

                if (editors.has(formId)) {
                    editors.get(formId).destroy().catch(error => console.error('Error destroying CKEditor:', error));
                    editors.delete(formId);
                }

                const LICENSE_KEY = 'eyJhbGciOiJFUzI1NiJ9.eyJleHAiOjE3NTAzNzc1OTksImp0aSI6IjdhMGViMjcxLWY1YjAtNDk3ZC1iOTYzLTFlYWRhMjcxOGY3ZiIsInVzYWdlRW5kcG9pbnQiOiJodHRwczovL3Byb3h5LWV2ZW50LmNrZWRpdG9yLmNvbSIsImRpc3RyaWJ1dGlvbkNoYW5uZWwiOlsiY2xvdWQiLCJkcnVwYWwiLCJzaCJdLCJ3aGl0ZUxhYmVsIjp0cnVlLCJsaWNlbnNlVHlwZSI6InRyaWFsIiwiZmVhdHVyZXMiOlsiKiJdLCJ2YyI6IjE1NTk1MDBkIn0.97t5NfnTUy3iThZIg92yj2aLEgkbchX8d6nmhXhjAdRr0Pp8H5kcmvE2VZ0ZiwvzYcUgjH7uaEA76G8p7eIP1Q';

                // Ambil data awal dari textarea
                let initialData = element.value || '';
                // Bersihkan data dari karakter yang tidak diperlukan seperti { dan }
                initialData = initialData.replace(/^{|}$/g, '');

                const editorConfig = {
                    toolbar: {
                        items: [
                            'undo',
                            'redo',
                            '|',
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            '|',
                            'link',
                            'insertTable',
                            'insertTableLayout',
                            'blockQuote',
                            '|',
                            'bulletedList',
                            'numberedList',
                            'todoList',
                            'outdent',
                            'indent'
                        ],
                        shouldNotGroupWhenFull: false
                    },
                    plugins: [
                        Autoformat,
                        Autosave,
                        BalloonToolbar,
                        BlockQuote,
                        Bold,
                        Essentials,
                        Heading,
                        Indent,
                        IndentBlock,
                        Italic,
                        Link,
                        List,
                        ListProperties,
                        Paragraph,
                        PasteFromOffice,
                        Subscript,
                        Superscript,
                        Table,
                        TableCaption,
                        TableCellProperties,
                        TableColumnResize,
                        TableLayout,
                        TableProperties,
                        TableToolbar,
                        TextTransformation,
                        TodoList,
                        Underline
                    ],
                    balloonToolbar: ['bold', 'italic', '|', 'link', '|', 'bulletedList', 'numberedList'],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                            { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                            { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                            { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                        ]
                    },
                    initialData: initialData, // Gunakan data awal yang telah dibersihkan
                    licenseKey: LICENSE_KEY,
                    link: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        decorators: {
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: { download: 'file' }
                            }
                        }
                    },
                    list: {
                        properties: { styles: true, startIndex: true, reversed: true }
                    },
                    menuBar: { isVisible: true },
                    placeholder: 'Type or paste your content here!',
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
                    }
                };

                return ClassicEditor.create(element, editorConfig)
                    .then(editor => {
                        editors.set(formId, editor);
                        return editor;
                    })
                    .catch(error => {
                        console.error('CKEditor initialization error:', error);
                    });
            }

            function initializeDropzone(element, formId, categoryIndex, dataIndex, dataId = null) {
                if (dropzones.has(formId)) {
                    dropzones.get(formId).destroy();
                    dropzones.delete(formId);
                }

                const dropzone = new Dropzone(element, {
                    url: "{{ route('kriteria.save', ['id' => $kriteria->id_kriteria]) }}",
                    paramName: `data_pendukung[${categoryIndex}][${dataIndex}][gambar][]`,
                    maxFilesize: 2,
                    acceptedFiles: 'image/jpeg,image/png,image/jpg',
                    addRemoveLinks: true,
                    dictDefaultMessage: '+ Seret gambar atau klik untuk upload',
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
                            inputs.forEach(input => {
                                if (input.name.includes('data_pendukung')) {
                                    formData.append(input.name, input.value);
                                }
                            });
                            if (dataId) formData.append('id_data_pendukung', dataId);
                        });
                        this.on('queuecomplete', function () {
                            const form = document.getElementById(formId);
                            const formData = new FormData(form);
                            formData.append('_token', '{{ csrf_token() }}');
                            formData.append('draft', '1');
                            sendFormData(formData, form);
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

            document.addEventListener('click', function (e) {
                const saveBtn = e.target.closest('.save-btn');
                if (saveBtn) {
                    e.preventDefault();
                    const form = saveBtn.closest('form');
                    const formId = form.id;
                    const editor = editors.get(formId);
                    if (editor) {
                        const textarea = form.querySelector('.ckeditor');
                        textarea.value = editor.getData();
                    }
                    const dropzone = dropzones.get(formId);
                    if (dropzone && dropzone.files.length > 0) {
                        dropzone.processQueue();
                    } else {
                        const formData = new FormData(form);
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('draft', '1');
                        sendFormData(formData, form);
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
                                location.reload();
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', 'Gagal menyimpan data.', 'error');
                            }
                        });
                    }
                });
            }

            document.addEventListener('click', function (e) {
                const removeImageBtn = e.target.closest('.remove-image');
                if (removeImageBtn) {
                    e.preventDefault();
                    const gambarId = removeImageBtn.dataset.id;
                    const url = "{{ route('kriteria.deleteGambar', ['id' => $kriteria->id_kriteria, 'gambarId' => ':gambarId']) }}".replace(':gambarId', gambarId);

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Yakin menghapus gambar ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#3498db',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    Swal.fire('Sukses!', 'Gambar berhasil dihapus.', 'success');
                                    removeImageBtn.closest('div').remove();
                                },
                                error: function (xhr) {
                                    Swal.fire('Error!', 'Gagal menghapus gambar. ' + xhr.responseText, 'error');
                                }
                            });
                        }
                    });
                }

                const deleteDataBtn = e.target.closest('.delete-btn');
                if (deleteDataBtn) {
                    e.preventDefault();
                    const form = deleteDataBtn.closest('form');
                    const dataId = form.querySelector('input[name^="data_pendukung"][name$="[id_data_pendukung]"]').value;
                    const url = "{{ route('kriteria.deleteData', ['id' => $kriteria->id_kriteria, 'dataId' => ':dataId']) }}".replace(':dataId', dataId);

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Yakin menghapus data pendukung ini (termasuk semua gambar)?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#3498db',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                method: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id_data_pendukung: dataId
                                },
                                success: function (response) {
                                    Swal.fire('Sukses!', 'Data pendukung berhasil dihapus.', 'success');
                                    form.remove();
                                    location.reload();
                                },
                                error: function (xhr) {
                                    Swal.fire('Error!', 'Gagal menghapus data. ' + xhr.responseText, 'error');
                                }
                            });
                        }
                    });
                }
            });

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

            document.getElementById('submit-form').addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Kriteria ini akan disubmit dan tidak dapat diedit lagi sampai divalidasi. Lanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2ecc71',
                    cancelButtonColor: '#e74c3c',
                    confirmButtonText: 'Ya, Submit!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
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

            <!-- Form tambah data pendukung -->
            @if ($kriteria->status_selesai != 'Submitted')
            <form id="add-form-{{ $index }}" class="data-pendukung-form-add add-form" data-category="{{ $index }}">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Data Pendukung</label>
                        <textarea class="form-control" name="data_pendukung[{{ $index }}][new][nama_data]" rows="2"></textarea>
                        <input type="hidden" name="data_pendukung[{{ $index }}][new][id_detail_kriteria]" value="{{ $detail->id_detail_kriteria }}">
                        <input type="hidden" name="data_pendukung[{{ $index }}][new][index]" value="new">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Data Pendukung</label>
                        <div class="editor-container editor-container_classic-editor">
                            <div class="editor-container__editor">
                                <textarea class="ckeditor" name="data_pendukung[{{ $index }}][new][deskripsi_data]"></textarea>
                            </div>
                        </div>
                    </div>
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

                        <!-- Form edit data pendukung -->
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
                                        <div class="editor-container editor-container_classic-editor">
                                            <div class="editor-container__editor">
                                                <textarea class="ckeditor" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][deskripsi_data]">{!! $dataPendukung->deskripsi_data !!}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>URL Data Pendukung</label>
                                        <textarea class="form-control" name="data_pendukung[{{ $index }}][{{ $dataIndex }}][hyperlink_data]" rows="2">{{ $dataPendukung->hyperlink_data }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Data</label>
                                        @if ($dataPendukung->gambar->count() > 0)
                                            <div class="existing-images" style="margin-bottom: 10px;">
                                                @foreach ($dataPendukung->gambar as $gambar)
                                                    <div style="display: inline-block; position: relative; margin-right: 10px;">
                                                        <img src="{{ asset('storage/' . $gambar->gambar) }}" alt="Gambar" style="max-width: 100px; max-height: 100px; border: 1px solid #ddd; border-radius: 5px;">
                                                        <a href="#" class="remove-image" data-id="{{ $gambar->id_gambar }}" style="position: absolute; top: 0; right: 0; color: red; font-weight: bold; text-decoration: none; background: #fff; border-radius: 50%; padding: 0 5px;">X</a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="dropzone" id="dropzone-{{ $index }}-{{ $dataIndex }}"></div>
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
                <form action="{{ route('kriteria.submit', ['id' => $kriteria->id_kriteria]) }}" method="POST" id="submit-form" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success submit-btn" id="submit-button">Submit</button>
                </form>
            </div>
        @endif
    </div>
@endsection