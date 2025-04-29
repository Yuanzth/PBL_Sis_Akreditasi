@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Transaksi Penjualan</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ route('penjualan.create_ajax') }}')" class="btn btn-success">
                    <i class="fas fa-cash-register"></i> Transaksi Baru
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered table-sm table-striped table-hover" id="table-penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Transaksi</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Kasir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection {{-- Pastikan @section ditutup dengan benar --}}

@push('js') {{-- Pastikan @push('js') ada --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                $('#myModal').modal('show');
            });
        }

        function showDetail(url) {
            $('#myModal').load(url, function () {
                $(this).modal('show');

                // Handle print button after modal shown
                $(this).find('.btn-success').off('click').on('click', function () {
                    window.print();
                });
            });
        }
        function confirmDelete(url) {
            Swal.fire({
                title: 'Loading...',
                html: 'Memuat formulir konfirmasi',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();

                    // Load modal konfirmasi
                    $('#myModal').load(url, function () {
                        $(this).modal('show');
                        Swal.close();
                    });
                }
            });
        }

        var tablePenjualan;
        $(document).ready(function () {
            tablePenjualan = $('#table-penjualan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('penjualan.list') }}",
                    type: "POST",
                    data: function (d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex",
                        name: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false
                    },
                    {
                        data: "penjualan_kode",
                        name: "penjualan_kode",
                        className: "text-center",
                        width: "16%"
                    },
                    {
                        data: "pembeli",
                        name: "pembeli",
                        className: "text-left",
                        width: "16%"
                    },
                    {
                        data: "penjualan_tanggal",
                        name: "penjualan_tanggal",
                        className: "text-center",
                        width: "17%"
                    },
                    {
                        data: "total",
                        name: "total",
                        className: "text-right",
                        width: "16%",
                        render: function (data) {
                            return `<span class="font-weight-bold">${data}</span>`;
                        }
                    },
                    {
                        data: "nama",
                        name: "user.nama",
                        className: "text-center",
                        width: "15%"
                    },
                    {
                        data: "aksi",
                        name: "aksi",
                        className: "text-center",
                        width: "15%",
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('#table-penjualan_filter input').unbind().bind().on('keyup', function (e) {
                if (e.keyCode == 13) {
                    tablePenjualan.search(this.value).draw();
                }
            });
        });
    </script>
@endpush {{-- Pastikan @endpush ada dan tidak typo --}}