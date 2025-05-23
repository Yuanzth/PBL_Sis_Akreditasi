@extends('layouts.template')

@section('title', 'Finalisasi Dokumen')

@section('content')
<div class="container-fluid">
    <div class="card card-success card-outline">
        <div class="card-body">
            <form method="GET" action="{{ route('finalisasi.index') }}">
                <div class="row mb-4 align-items-center justify-content-between">
                    {{-- Kolom Filter Kriteria (rata kiri) --}}
                    <div class="col-md-3">
                        <label class="form-label">Filter :</label>
                        <select name="kategori" class="form-control" onchange="this.form.submit()">
                            <option value="">-- Semua --</option>
                            @for ($i = 1; $i <= 9; $i++)
                                <option value="Kriteria {{ $i }}" {{ request('kategori') == "Kriteria $i" ? 'selected' : '' }}>
                                    Kriteria {{ $i }}
                                </option>
                            @endfor
                        </select>
                        <small class="text-muted">Filter berdasarkan kategori kriteria</small>
                    </div>

                    {{-- Kolom Search (rata kanan) --}}
                    <div class="col-md-4 d-flex justify-content-end">
                        <div class="input-group" style="width: 70%;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Search..." value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-hover table-striped">
                <thead class="bg-success text-white text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Tanggal Validasi</th>
                        <th>Status Validasi</th>
                        <th>Divalidasi Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $index => $doc)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $doc->validasi->kriteria->nama_kriteria ?? '-' }}</td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($doc->validasi->tanggal_validasi ?? now())->format('d-m-Y H:i:s') }}
                        </td>
                        <td class="text-center">
                            @if(isset($doc->validasi->status_validasi) && strtolower($doc->validasi->status_validasi) == 'valid')
                                <span class="badge bg-success">Berhasil Divalidasi</span>
                            @else
                                <span class="badge bg-danger">Belum Valid</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $doc->validasi->user->name ?? 'KPS/Kajur' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Tombol Export di kanan bawah --}}
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('finalisasi.export.pdf', ['kategori' => request('kategori')]) }}" class="btn btn-primary">
                    Ekspor Dokumen
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
