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

    <h2 class="text-center">Dokumen Akreditasi Final</h2>

    @foreach ($kriteriaList as $kriteria)
        <div class="section">
            <h3>Kriteria {{ $kriteria->id_kriteria }}</h3>
            @forelse ($kriteria->detailKriteria as $detail)
                <div class="section">
                    <h4>{{ $detail->kategori->nama_kategori }} (Penetapan - Pengendalian)</h4>
                    @if ($detail->dataPendukung->isEmpty())
                        <p>Tidak ada data pendukung untuk kategori ini.</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Nama Data</th>
                                    <th>Deskripsi</th>
                                    <th>Hyperlink</th>
                                    <th>Gambar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail->dataPendukung as $data)
                                    <tr>
                                        <td>{{ $data->nama_data }}</td>
                                        <td>{{ $data->deskripsi_data ?? '-' }}</td>
                                        <td>
                                            @if ($data->hyperlink_data)
                                                <a href="{{ $data->hyperlink_data }}">{{ $data->hyperlink_data }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @forelse ($data->gambar as $gambar)
                                                <img src="{{ public_path('storage/' . $gambar->gambar) }}" class="image">
                                            @empty
                                                -
                                            @endforelse
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @empty
                <p>Tidak ada detail kriteria untuk Kriteria {{ $kriteria->id_kriteria }}.</p>
            @endforelse
        </div>
    @endforeach
</body>
</html>