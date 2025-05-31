<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .border-bottom-header { border-bottom: 2px solid #000; margin-bottom: 20px; }
        .text-center { text-align: center; }
        .d-block { display: block; }
        .font-11 { font-size: 11px; }
        .font-13 { font-size: 13px; }
        .font-10 { font-size: 10px; }
        .font-bold { font-weight: bold; }
        .image { max-width: 100px; max-height: 100px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { max-width: 100px; max-height: 100px; }
        .page-break { page-break-before: always; }
        ul { list-style-type: none; padding-left: 20px; }
        ul li::before { content: "- "; }
        ul li { margin-bottom: 5px; } /* Jarak antar data pendukung */
        .deskripsi {
            font-size: 14px; /* Ukuran font konsisten */
            line-height: 1.5; /* Jarak baris yang nyaman */
            padding: 2px 0; /* Padding vertikal kecil */
            margin: 0; /* Hilangkan margin bawaan */
            display: block; /* Pastikan elemen block */
        }
        /* Aturan tambahan untuk konsistensi HTML */
        .deskripsi p {
            margin: 0; /* Hilangkan margin bawaan dari <p> */
            padding: 0;
        }
        .deskripsi a {
            color: #0000FF; /* Warna link biru standar */
            text-decoration: underline; /* Garis bawah pada link */
        }
    </style>
</head>
<body>
    <table class="border-bottom-header">
        <tr>
            <td width="15%" class="text-center">
                <img src="{{ public_path('landing_page/logopoltek.png') }}" style="width:80px;">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">
                    KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI
                </span>
                <span class="text-center d-block font-13 font-bold mb-1">
                    POLITEKNIK NEGERI MALANG
                </span>
                <span class="text-center d-block font-10">
                    Jl. Soekarno-Hatta No. 9 Malang 65141
                </span>
                <span class="text-center d-block font-10">
                    Telepon (0341) 404424 Pes. 101-105, 0341-404420, Fax. (0341) 404420
                </span>
                <span class="text-center d-block font-10">
                    Laman: www.polinema.ac.id
                </span>
            </td>
        </tr>
    </table>

    <h2 class="text-center">LAPORAN FINALISASI DOKUMEN AKREDITASI</h2>
    <p class="text-center font-10">Tanggal: {{ now()->format('d-m-Y H:i:s') }}</p>

    @foreach ($kriteriaList as $index => $kriteria)
        <div class="section {{ $index > 0 ? 'page-break' : '' }}">
            <h3 class="text-center">LAPORAN DATA KRITERIA {{ $kriteria->id_kriteria }}</h3>
            @forelse ($kriteria->detailKriteria as $detailIndex => $detail)
                <div class="section">
                    <h4>{{ $detailIndex + 1 }}. {{ $detail->kategori->nama_kategori }}</h4>
                    <ul>
                        @forelse ($detail->dataPendukung as $data)
                            <li>
                                <strong>{{ $data->nama_data }}</strong><br>
                                Deskripsi: <span class="deskripsi">{!! $data->deskripsi_data !!}</span><br>
                                @if($data->gambar->isNotEmpty())
                                    Gambar:
                                    @foreach($data->gambar as $index => $gambar)
                                        <img src="{{ public_path('storage/' . $gambar->gambar) }}" alt="Gambar {{ $index + 1 }}" class="image">
                                    @endforeach
                                @else
                                    Gambar: -
                                @endif
                            </li>
                        @empty
                            <li>Tidak ada data pendukung untuk kategori ini.</li>
                        @endforelse
                    </ul>
                </div>
            @empty
                <p>Tidak ada detail kriteria untuk Kriteria {{ $kriteria->id_kriteria }}.</p>
            @endforelse
        </div>
    @endforeach
</body>
</html>