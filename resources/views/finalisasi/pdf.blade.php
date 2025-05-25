<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 6px 20px;
            line-height: 1.5;
        }
        .text-center {
            text-align: center;
        }
        .border-bottom-header {
            border-bottom: 1px solid;
        }
        .font-12 {
            font-size: 12pt;
        }
        .document-content {
            margin-top: 20px;
            white-space: pre-line;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="border-bottom-header" style="width: 100%;">
        <tr>
            <!-- Logo Kiri (Polinema) -->
            <td width="15%" class="text-center">
                <img src="{{ public_path('public/polinema-bw.png') }}" style="width:80px;">
            </td>

            <!-- Teks Header -->
            <td width="70%">
                <div class="text-center font-12"><strong>KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</strong></div>
                <div class="text-center font-12"><strong>POLITEKNIK NEGERI MALANG</strong></div>
                <div class="text-center" style="font-size: 10pt;">Jalan Soekarno Hatta Nomor 9 Jatimulyo, Lowokwaru, Malang 65141</div>
                <div class="text-center" style="font-size: 10pt;">Telepon (0341) 404424, 404425, Faksimile (0341) 404420</div>
                <div class="text-center" style="font-size: 10pt;">Laman www.polinema.ac.id</div>
            </td>

            <!-- Logo Kanan (JTI) -->
            <td width="15%" class="text-center">
                <img src="{{ public_path('logo_jti.png') }}" style="width:80px;">
            </td>
        </tr>
    </table>

    <h3 class="text-center">LAPORAN FINALISASI DOKUMEN</h3>

    <!-- Hanya menampilkan isi dokumen -->
    @foreach($documents as $doc)
        <div class="document-content">
            {!! nl2br(e($doc->final_document)) !!}
        </div>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>
