@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Detail Validasi - {{ $kriteria->nama_kriteria ?? 'Kriteria ' . $kriteria->id_kriteria }}</h3>
        <a href="{{ route('validasi.tahap.satu') }}" class="btn btn-secondary float-right">Kembali</a>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                    <textarea class="form-control" name="comment" rows="4" placeholder="Masukkan komentar..."></textarea>
                </div>
                <div class="form-group d-flex">
                    @if($kriteria->status_selesai === 'Submitted' && (!$kriteria->validasi->first() || $kriteria->validasi->first()->status !== 'Sudah Tugas Tim'))
                        <form action="{{ route('validasi.tahap.satu.approve', $kriteria->id_kriteria) }}" method="POST" class="mr-2">
                            @csrf
                            <input type="hidden" name="comment" value="{{ old('comment') }}">
                            <button type="submit" class="btn btn-success">Validasi</button>
                        </form>
                        <form action="{{ route('validasi.tahap.satu.reject', $kriteria->id_kriteria) }}" method="POST">
                            @csrf
                            <input type="hidden" name="comment" value="{{ old('comment') }}">
                            <button type="submit" class="btn btn-danger">Tolak</button>
                        </form>
                    @else
                        <p>Status sudah final atau belum submitted.</p>
                    @endif
                </div>
            </div>
            <!-- Kolom Kanan: PDF Viewer -->
            <div class="col-md-6">
                @if($pdfPath)
                    <div class="pdf-container" style="height: 500px; overflow-y: auto; border: 1px solid #ddd;">
                        <div id="pdfViewer"></div>
                    </div>
                    <div class="pdf-controls mt-2">
                        <button id="prevPage" class="btn btn-sm btn-primary">Halaman Sebelumnya</button>
                        <button id="nextPage" class="btn btn-sm btn-primary">Halaman Berikutnya</button>
                        <span id="pageInfo" class="ml-2"></span>
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
<style>
    .pdf-container {
        position: relative;
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
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script>
    // Konfigurasi pdf.js worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

    // Ambil nilai textarea dan masukkan ke input hidden sebelum submit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const comment = document.querySelector('textarea[name="comment"]').value;
            form.querySelector('input[name="comment"]').value = comment;
        });
    });

    // Logika untuk merender PDF dan menangani link
    $(document).ready(function() {
        const pdfUrl = "{{ $pdfPath }}";
        const pdfViewer = document.getElementById('pdfViewer');
        let pdfDoc = null;
        let currentPage = 1;
        let totalPages = 0;

        // Muat PDF
        pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
            pdfDoc = pdf;
            totalPages = pdf.numPages;
            document.getElementById('pageInfo').textContent = `Halaman ${currentPage} dari ${totalPages}`;
            renderAllPages();
        }).catch(err => {
            console.error('Gagal memuat PDF:', err);
            pdfViewer.innerHTML = '<p>Gagal memuat PDF. Silakan coba lagi.</p>';
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
                const scale = 0.8;
                const viewport = page.getViewport({ scale });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const pageContainer = document.getElementById(`page-${pageNum}`);
                pageContainer.appendChild(canvas);

                // Render PDF ke canvas
                const renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext).promise.then(() => {
                    // Dapatkan link di halaman ini
                    page.getAnnotations().then(annotations => {
                        annotations.forEach(annotation => {
                            if (annotation.subtype === 'Link' && annotation.url && annotation.url.includes('drive.google.com')) {
                                const rect = annotation.rect; // Koordinat link [x1, y1, x2, y2]
                                const linkOverlay = document.createElement('div');
                                linkOverlay.className = 'link-overlay';
                                linkOverlay.style.left = `${rect[0] * scale}px`;
                                linkOverlay.style.bottom = `${rect[1] * scale}px`;
                                linkOverlay.style.width = `${(rect[2] - rect[0]) * scale}px`;
                                linkOverlay.style.height = `${(rect[3] - rect[1]) * scale}px`;

                                // Tambahkan event klik untuk membuka modal
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

        // Navigasi halaman
        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                document.getElementById('pageInfo').textContent = `Halaman ${currentPage} dari ${totalPages}`;
                pdfViewer.scrollTop = document.getElementById(`page-${currentPage}`).offsetTop;
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                document.getElementById('pageInfo').textContent = `Halaman ${currentPage} dari ${totalPages}`;
                pdfViewer.scrollTop = document.getElementById(`page-${currentPage}`).offsetTop;
            }
        });

        // Reset iframe src saat modal ditutup untuk menghentikan loading
        $('#gdriveModal').on('hidden.bs.modal', function() {
            $('#gdriveIframe').attr('src', '');
        });
    });
</script>
@endpush
@endsection