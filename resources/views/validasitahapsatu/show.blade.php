@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Validasi - {{ $kriteria->nama_kriteria ?? 'Kriteria ' . $kriteria->id_kriteria }}</h3>
        <a href="{{ route('validasi.tahap.satu') }}" class="btn btn-secondary float-right">Kembali</a>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success" id="success-message">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row">
            <!-- Kolom Kiri: Informasi dan Tombol -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Kriteria:</label>
                    <p>{{ $kriteria->nama_kriteria ?? 'Kriteria ' . $kriteria->id_kriteria }}</p>
                </div>
                <div class="form-group">
                    <label>Tanggal Submit:</label>
                    <p>{{ $kriteria->status_selesai === 'Submitted' ? ($kriteria->updated_at ?? $kriteria->created_at)->format('d/m/Y H:i:s') : '-' }}</p>
                </div>
                <div class="form-group">
                    <label>Komentar:</label>
                    <textarea class="form-control" name="comment" id="comment" rows="4" placeholder="Masukkan komentar..."></textarea>
                </div>
                <div class="form-group d-flex" id="action-buttons">
                    @php
                        $validasiTahapSatu = $kriteria->validasi->whereIn('id_user', [10, 11])
                            ->where('updated_at', '>=', $kriteria->updated_at)
                            ->first();
                    @endphp
                    @if($kriteria->status_selesai === 'Submitted' && !$validasiTahapSatu)
                        <button type="button" class="btn btn-success mr-2" id="approve-btn">Validasi</button>
                        <button type="button" class="btn btn-danger" id="reject-btn">Tolak</button>
                    @else
                        <p>Kriteria ini sudah divalidasi.</p>
                    @endif
                </div>
            </div>
            <!-- Kolom Kanan: PDF Viewer -->
            <div class="col-md-6">
                @if($pdfPath)
                    <div class="pdf-viewer-container" style="background-color: #4a4a4a; padding: 15px; border-radius: 5px;">
                        <!-- Kontrol Zoom -->
                        <div class="zoom-controls mb-3 d-flex justify-content-center align-items-center">
                            <button id="zoomOut" class="btn btn-sm btn-secondary"><i class="fas fa-search-minus"></i></button>
                            <span id="zoomInfo" class="mx-2">100%</span>
                            <button id="zoomIn" class="btn btn-sm btn-secondary"><i class="fas fa-search-plus"></i></button>
                        </div>
                        <!-- PDF Container -->
                        <div class="pdf-container" style="height: 500px; overflow-y: auto; border: 1px solid #ccc; display: flex; justify-content: center; align-items: flex-start;">
                            <div id="pdfViewer"></div>
                        </div>
                        <!-- Kontrol Navigasi -->
                        <div class="navigation-controls mt-2 d-flex justify-content-between align-items-center">
                            <div class="navigation-buttons d-flex align-items-center">
                                <button id="prevPage" class="btn btn-sm btn-primary"><i class="fas fa-arrow-left"></i></button>
                                <span id="pageInfo" class="mx-2">Halaman 1 dari 1</span>
                                <button id="nextPage" class="btn btn-sm btn-primary"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                @else
                    <p>Tidak ada dokumen PDF yang tersedia.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Pratinjau Google Drive -->
<div class="modal fade" id="gdriveModal" tabindex="-1" role="dialog" aria-labelledby="gdriveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gdriveModalLabel">Pratinjau Google Drive</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe id="gdriveIframe" src="" frameborder="0" style="width: 100%; height: 500px;"></iframe>
            </div>
        </div>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .pdf-viewer-container {
        color: #fff;
    }
    .pdf-container {
        position: relative;
        background-color: #fff; /* Latar belakang putih untuk PDF */
    }
    .pdf-page {
        margin-bottom: 10px;
        border: 1px solid #ccc;
        position: relative;
    }
    .link-overlay {
        position: absolute;
        cursor: pointer;
        background: rgba(0, 0, 255, 0.1);
    }
    .link-overlay:hover {
        background: rgba(0, 0, 255, 0.3);
    }
    .navigation-controls {
        position: relative;
    }
    .navigation-buttons {
        flex-grow: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

    const pdfUrl = "{{ $pdfPath }}";
    const pdfViewer = document.getElementById('pdfViewer');
    const pdfContainer = document.querySelector('.pdf-container');
    let pdfDoc = null;
    let currentPage = 1;
    let totalPages = 0;
    let scale = 0.8; // Skala awal

    // Muat PDF
    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
        pdfDoc = pdf;
        totalPages = pdf.numPages;
        updatePageInfo();
        updateZoomInfo();
        renderAllPages();
        updateNavigationButtons();
        setupScrollListener();
    }).catch(err => {
        console.error('Gagal memuat PDF:', err);
        pdfViewer.innerHTML = '<p style="color: #fff;">Gagal memuat dokumen PDF. Silakan coba lagi.</p>';
    });

    // Render semua halaman
    function renderAllPages() {
        pdfViewer.innerHTML = ''; // Kosongkan viewer
        for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
            const pageContainer = document.createElement('div');
            pageContainer.className = 'pdf-page';
            pageContainer.id = `page-${pageNum}`;
            pdfViewer.appendChild(pageContainer);

            renderPage(pageNum);
        }
    }

    // Render halaman tertentu
    function renderPage(pageNum) {
        pdfDoc.getPage(pageNum).then(page => {
            const viewport = page.getViewport({ scale });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const pageContainer = document.getElementById(`page-${pageNum}`);
            pageContainer.appendChild(canvas);

            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            page.render(renderContext).promise.then(() => {
                page.getAnnotations().then(annotations => {
                    annotations.forEach(annotation => {
                        if (annotation.subtype === 'Link' && annotation.url && annotation.url.includes('drive.google.com')) {
                            const rect = annotation.rect;
                            const linkOverlay = document.createElement('div');
                            linkOverlay.className = 'link-overlay';
                            linkOverlay.style.left = `${rect[0] * scale}px`;
                            linkOverlay.style.bottom = `${rect[1] * scale}px`;
                            linkOverlay.style.width = `${(rect[2] - rect[0]) * scale}px`;
                            linkOverlay.style.height = `${(rect[3] - rect[1]) * scale}px`;

                            linkOverlay.addEventListener('click', () => {
                                let embedLink = annotation.url;
                                if (embedLink.includes('/file/d/')) {
                                    const fileId = embedLink.match(/\/d\/(.+?)\//)?.[1];
                                    if (fileId) {
                                        embedLink = `https://drive.google.com/file/d/${fileId}/preview`;
                                    }
                                } else if (embedLink.includes('/folders/')) {
                                    const folderId = embedLink.match(/\/folders\/(.+)/)?.[1];
                                    if (folderId) {
                                        embedLink = `https://drive.google.com/embeddedfolderview?id=${folderId}#list`;
                                    }
                                }

                                $('#gdriveIframe').attr('src', embedLink);
                                $('#gdriveModal').modal('show');
                            });

                            pageContainer.appendChild(linkOverlay);
                        }
                    });
                });
            });
        });
    }

    // Perbarui info halaman
    function updatePageInfo() {
        document.getElementById('pageInfo').textContent = `Halaman ${currentPage} dari ${totalPages}`;
    }

    // Perbarui info zoom
    function updateZoomInfo() {
        const zoomPercentage = Math.round(scale * 100);
        document.getElementById('zoomInfo').textContent = `${zoomPercentage}%`;
    }

    // Perbarui status tombol navigasi
    function updateNavigationButtons() {
        const prevButton = document.getElementById('prevPage');
        const nextButton = document.getElementById('nextPage');
        if (prevButton && nextButton) {
            prevButton.disabled = currentPage <= 1;
            nextButton.disabled = currentPage >= totalPages;
        }
    }

    // Setup listener untuk scroll
    function setupScrollListener() {
        pdfContainer.addEventListener('scroll', () => {
            const containerHeight = pdfContainer.clientHeight;
            const scrollTop = pdfContainer.scrollTop;
            const pages = pdfViewer.getElementsByClassName('pdf-page');

            for (let i = 0; i < pages.length; i++) {
                const page = pages[i];
                const rect = page.getBoundingClientRect();
                const pageTop = rect.top + scrollTop;

                if (pageTop >= scrollTop && pageTop < scrollTop + containerHeight) {
                    const newPage = parseInt(page.id.split('-')[1]);
                    if (newPage !== currentPage) {
                        currentPage = newPage;
                        updatePageInfo();
                        updateNavigationButtons();
                    }
                    break;
                }
            }
        });
    }

    // Navigasi halaman
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            updatePageInfo();
            updateNavigationButtons();
            const pageElement = document.getElementById(`page-${currentPage}`);
            if (pageElement) {
                pageElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        if (currentPage < totalPages) {
            currentPage++;
            updatePageInfo();
            updateNavigationButtons();
            const pageElement = document.getElementById(`page-${currentPage}`);
            if (pageElement) {
                pageElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });

    // Zoom In
    document.getElementById('zoomIn').addEventListener('click', () => {
        scale += 0.1;
        updateZoomInfo();
        renderAllPages();
    });

    // Zoom Out
    document.getElementById('zoomOut').addEventListener('click', () => {
        if (scale > 0.1) {
            scale -= 0.1;
            updateZoomInfo();
            renderAllPages();
        }
    });

    // SweetAlert untuk Validasi
    $('#approve-btn').on('click', function() {
        Swal.fire({
            title: 'Konfirmasi Validasi',
            text: 'Apakah Anda yakin ingin memvalidasi kriteria ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Validasi',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const comment = $('#comment').val();
                $.ajax({
                    url: '{{ route("validasi.tahap.satu.approve", $kriteria->id_kriteria) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment: comment
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Validasi tahap satu berhasil diterima.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#action-buttons').html('<p>Kriteria ini sudah divalidasi atau belum submitted.</p>');
                            $('#success-message').remove(); // Hapus notifikasi default
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON.error || 'Terjadi kesalahan saat validasi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });

    // SweetAlert untuk Penolakan
    $('#reject-btn').on('click', function() {
        const comment = $('#comment').val().trim();
        if (!comment) {
            Swal.fire({
                title: 'Komentar Diperlukan',
                text: 'Silakan masukkan komentar sebelum menolak kriteria ini.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Penolakan',
            text: 'Apakah Anda yakin ingin menolak kriteria ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("validasi.tahap.satu.reject", $kriteria->id_kriteria) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        comment: comment
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Validasi tahap satu berhasil ditolak.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#action-buttons').html('<p>Kriteria ini sudah divalidasi atau belum submitted.</p>');
                            $('#success-message').remove(); // Hapus notifikasi default
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON.error || 'Terjadi kesalahan saat penolakan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection