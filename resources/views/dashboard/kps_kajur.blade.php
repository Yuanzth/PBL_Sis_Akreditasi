@extends('layouts.template')

@push('css')
<style>
    .container-fluid {
        padding: 20px;
    }
    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .card h1 {
        color: #333;
        margin-bottom: 15px;
    }
    .card p {
        color: #555;
    }
    .logout-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #dc3545;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }
    .logout-btn:hover {
        background-color: #c82333;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card">
        <h1>Selamat Datang di Dashboard </h1>
        <p>Ini adalah dashboard untuk pengguna dengan level Admin.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</div>
@endsection