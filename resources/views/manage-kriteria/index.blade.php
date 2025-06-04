@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="welcome-card">
        <h3>Kelola Kriteria</h3>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

    <form action="{{ route('kriteria.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Kriteria</label>
            <input type="text" name="nama_kriteria" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Level</label>
            <select name="id_level" class="form-control" required>
                @foreach (\App\Models\LevelModel::whereIn('id_level', [5, 6, 7, 8, 9, 10, 11, 12, 13])->get() as $level)
                    <option value="{{ $level->id_level }}">{{ $level->level_nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Kriteria</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Nama Kriteria</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kriteria as $item)
                <tr>
                    <td>{{ $item->nama_kriteria }}</td>
                    <td>{{ $item->level->level_nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection