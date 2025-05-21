@extends('layouts.template')

@section('title', 'Validasi Data - KJM')

@section('content')
<div class="container-fluid">
    <div class="card card-success card-outline">
        <div class="card-header">
            <h3 class="card-title">Daftar Validasi Data Kriteria</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
                <thead class="bg-success text-white">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Tanggal Submit</th>
                        <th>Status Submit</th>
                        <th>Status Validasi</th>
                        <th>Divalidasi Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataValidasi as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_kriteria }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_submit)->format('d-m-Y H:i:s') }}</td>
                        <td class="text-center">
                            @if($item->status_submit == 'Submitted')
                                <span class="badge bg-success">Submitted</span>
                            @else
                                <span class="badge bg-warning text-dark">On Progress</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($item->status == 'Valid')
                                <span class="badge bg-success">Valid</span>
                            @elseif($item->status == 'Belum Valid')
                                <span class="badge bg-danger">Belum Valid</span>
                            @else
                                <span class="badge bg-secondary">Belum Divalidasi</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->user?->name ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ url('/validasi-data/'.$item->id_validasi.'/lihat') }}" class="btn btn-info btn-sm">Detail</a>
                            <form action="{{ url('/validasi-data/'.$item->id_validasi.'/update') }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Valid">
                                <button type="submit" class="btn btn-success btn-sm">Validasi</button>
                            </form>
                            <form action="{{ url('/validasi-data/'.$item->id_validasi.'/update') }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="Belum Valid">
                                <button type="submit" class="btn btn-danger btn-sm">Revisi</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection