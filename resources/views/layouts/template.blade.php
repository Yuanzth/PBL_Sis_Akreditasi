<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistem Akreditasi SIB') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    @stack('css')

    <!-- CSS untuk logo JTI -->
    <style>
        /* sidebar mode full */
        .layout-fixed .main-sidebar {
            width: 250px; 
        }

        /* set brand-link saat sidebar penuh */
        .brand-link {
            display: flex;
            align-items: center;
            padding: 15px 20px; 
            background-color: #D9D9D9; 
        }

        /* logo JTI */
        .brand-link img {
            height: 40px; /* Tetap ukuran logo */
            width: auto; /* lebar menyesuaikan proporsi */
            margin-right: 11px; /* jarak antara logo dan teks */
        }

        /* teks brand */
        .brand-text {
            font-size: 1.2rem;
            color: #000000; 
            font-weight: 600; 
        }

        /*  logo JTI saat sidebar di-minimize */
        .sidebar-mini.sidebar-collapse .brand-link {
            display: flex;
            justify-content: center; 
            align-items: center; 
            padding: 10px;
        }

        /* hide teks saat sidebar di-minimize */
        .sidebar-mini.sidebar-collapse .brand-text {
            display: none;
        }

        /*ukuran saat di-minimize */
        .sidebar-mini.sidebar-collapse .brand-link img {
            margin: 0; 
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" style="display: flex; flex-direction: column; min-height: 100vh;">
        <!-- Navbar -->
        @include('layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4"
            style="min-height: 100vh; display: flex; flex-direction: column; background-color: #D9D9D9;">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ asset('landing_page/logo/logo_jti.png') }}" alt="JTI Logo" height="40" width="40">
                <span class="brand-text font-weight-light" style="color: rgb(0, 0, 0);"><b>Sistem Akreditasi SIB</b></span>
            </a>

            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper" style="flex: 1 0 auto;">
            <!-- Content Header -->
            @include('layouts.breadcrumb')

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/45.1.0/ckeditor5.umd.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('js')
</body>

</html>