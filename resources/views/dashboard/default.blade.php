@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="welcome-card">
        <h3>Selamat Datang, {{ $user->name }}</h3>
        <p>Level Anda ({{ $user->level->level_kode }}) belum memiliki dashboard yang ditentukan. Silakan hubungi administrator untuk konfigurasi lebih lanjut.</p>
    </div>
</div>
@endsection