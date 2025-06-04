@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="welcome-card">
        <h3>Kelola Pengguna</h3>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

    <form action="{{ route('users.create') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Level</label>
            <select name="id_level" class="form-control" required>
                @foreach (\App\Models\LevelModel::all() as $level)
                    <option value="{{ $level->id_level }}">{{ $level->level_nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Username</th>
                <th>Nama</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->level->level_nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection