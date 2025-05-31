@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Dokumen Final</h3>
        <a href="{{ route('finalisasi.index') }}" class="btn btn-secondary float-right">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom untuk PDF Viewer -->
            <div class="col-md-12">
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
                        <a href="{{ $downloadUrl }}" class="btn btn-sm btn-primary" download><i class="fas fa-download"></i> Download</a>
                    </div>
                </div>
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
@endsection

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

    const pdfUrl = '{{ $pdfUrl }}';
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
</script>
@endpush