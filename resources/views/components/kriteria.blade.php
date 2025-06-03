<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kriteria {{ $kriteria->id_kriteria }} - Sistem Akreditasi SIB</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.0/dist/css/adminlte.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #333;
            background: #F9F9F9; /* Background konten utama */
        }

        .navbar-section {
            background: linear-gradient(180deg, #0B6B4F 0%, #0E8560 100%); /* Background navbar hijau */
            padding: 20px 0;
        }

        .nav-link-custom {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        .nav-link-custom:hover {
            color: #e0f2e9;
        }

        .logo-jti {
            height: 50px;
        }

        .login-btn {
            font-weight: bold;
        }

        .section-title {
            background-color: #0B6B4F;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .table-section {
            margin-bottom: 40px;
            background: white; /* Background putih untuk kotak */
            padding: 20px; /* Padding agar konten tidak terlalu mepet tepi */
            border-radius: 10px; /* Sudut membulat */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Bayangan ringan untuk efek kotak */
        }

        .table-section h4 {
            background-color: #e0f2e9;
            color: #1a3c34;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .table {
            background-color: white;
            border-radius: 5px;
            box-shadow: none; /* Hapus bayangan dari tabel karena sudah ada di table-section */
        }

        .pdf-link {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }

        .pdf-link:hover {
            text-decoration: underline;
        }

        .modal-fullscreen {
            max-width: 90%;
            margin: auto;
        }

        .modal-fullscreen .modal-content {
            height: 80vh;
        }

        .modal-fullscreen iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Panggil Navbar Kriteria -->
        @include('components.kriteria-navbar')

        <!-- Konten Utama -->
        <section class="content py-5">
            <div class="container">
                <!-- Judul Kriteria -->
                <h2 class="section-title text-center">Kriteria {{ $kriteria->id_kriteria }}</h2>

                <!-- Section Penetapan -->
                <div class="table-section">
                    <h4>Penetapan</h4>
                    <table class="table table-bordered" id="penetapanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Data Pendukung</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($detailKriteria['Penetapan']))
                                @foreach($detailKriteria['Penetapan'][0]->dataPendukung as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->nama_data }}</td>
                                        <td>
                                            @if($data->hyperlink_data)
                                                <a href="#" class="pdf-link" data-pdf-url="{{ $data->hyperlink_data }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Section Pelaksanaan -->
                <div class="table-section">
                    <h4>Pelaksanaan</h4>
                    <table class="table table-bordered" id="pelaksanaanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Data Pendukung</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($detailKriteria['Pelaksanaan']))
                                @foreach($detailKriteria['Pelaksanaan'][0]->dataPendukung as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->nama_data }}</td>
                                        <td>
                                            @if($data->hyperlink_data)
                                                <a href="#" class="pdf-link" data-pdf-url="{{ $data->hyperlink_data }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Section Evaluasi -->
                <div class="table-section">
                    <h4>Evaluasi</h4>
                    <table class="table table-bordered" id="evaluasiTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Data Pendukung</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($detailKriteria['Evaluasi']))
                                @foreach($detailKriteria['Evaluasi'][0]->dataPendukung as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->nama_data }}</td>
                                        <td>
                                            @if($data->hyperlink_data)
                                                <a href="#" class="pdf-link" data-pdf-url="{{ $data->hyperlink_data }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Section Pengendalian -->
                <div class="table-section">
                    <h4>Pengendalian</h4>
                    <table class="table table-bordered" id="pengendalianTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Data Pendukung</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($detailKriteria['Pengendalian']))
                                @foreach($detailKriteria['Pengendalian'][0]->dataPendukung as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->nama_data }}</td>
                                        <td>
                                            @if($data->hyperlink_data)
                                                <a href="#" class="pdf-link" data-pdf-url="{{ $data->hyperlink_data }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Section Peningkatan -->
                <div class="table-section">
                    <h4>Peningkatan</h4>
                    <table class="table table-bordered" id="peningkatanTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Data Pendukung</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($detailKriteria['Peningkatan']))
                                @foreach($detailKriteria['Peningkatan'][0]->dataPendukung as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $data->nama_data }}</td>
                                        <td>
                                            @if($data->hyperlink_data)
                                                <a href="#" class="pdf-link" data-pdf-url="{{ $data->hyperlink_data }}" data-bs-toggle="modal" data-bs-target="#pdfPreviewModal">Lihat</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Tombol untuk Melihat PDF (Jika Ada) -->
                @if($generatedDocument)
                    <div class="text-center mt-4">
                        <a href="{{ asset('storage/' . $generatedDocument->generated_document) }}" target="_blank" class="btn btn-primary">Lihat Dokumen PDF</a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Include Footer -->
        @include('components.footer')

        <!-- Modal untuk Pratinjau PDF -->
        <div class="modal fade" id="pdfPreviewModal" tabindex="-1" aria-labelledby="pdfPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfPreviewModalLabel">Pratinjau PDF</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfIframe" src="" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.0/dist/js/adminlte.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            // Inisialisasi DataTable untuk setiap tabel
            $('#penetapanTable').DataTable();
            $('#pelaksanaanTable').DataTable();
            $('#evaluasiTable').DataTable();
            $('#pengendalianTable').DataTable();
            $('#peningkatanTable').DataTable();

            // Handle klik link PDF untuk menampilkan modal pratinjau
            $('.pdf-link').on('click', function (e) {
                e.preventDefault();
                var pdfUrl = $(this).data('pdf-url');

                // Ubah URL Google Drive agar bisa di-embed
                var embedUrl = pdfUrl.replace('/view', '/preview');

                // Set URL ke iframe di dalam modal
                $('#pdfIframe').attr('src', embedUrl);

                // Tampilkan modal
                $('#pdfPreviewModal').modal('show');
            });

            // Reset iframe saat modal ditutup
            $('#pdfPreviewModal').on('hidden.bs.modal', function () {
                $('#pdfIframe').attr('src', '');
            });
        });
    </script>
</body>
</html>