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
                <img src="{{ asset('polinema-bw.png') }}" class="image">
            </td>
            <td width="85%">
                <span class="text-center d-block font-11 font-bold mb-1">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
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

    <h3 class="text-center">LAPORAN DATA KRITERIA {{ $kriteria->id_kriteria }}</h3>

    @foreach($detailKriteria as $detail)
        <div class="section">
            <h4>{{ $detail->kategori->nama_kategori }}</h4>
            @foreach($detail->dataPendukung as $data)
                <p><strong>{{ $data->nama_data }}</strong></p>
                <p>Deskripsi: 
                    @if($data->deskripsi_data)
                        {!! $data->deskripsi_data !!} <!-- Render sebagai HTML -->
                    @else
                        -
                    @endif
                </p>
                @if($data->gambar->isNotEmpty())
                    <p>Gambar:
                        @foreach($data->gambar as $index => $gambar)
                            <img src="{{ public_path('storage/' . $gambar->gambar) }}" alt="Gambar {{ $index + 1 }}">
                        @endforeach
                    </p>
                @else
                    <p>Gambar: -</p>
                @endif
            @endforeach
        </div>
    @endforeach
</body>
</html>