<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akreditasi SIB</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.0/dist/css/adminlte.min.css">
    <!-- Poppins Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            color: #333;
        }

        .hero-section {
            background: url('{{ asset('landing_page/background/landing_page.png') }}') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 120px 0;
            text-align: center;
        }

        .section {
            padding: 60px 0;
            text-align: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .card-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('components.header-hero')
        @include('components.profile')
        @include('components.visi-misi')
        @include('components.tujuan')
        @include('components.sasaran')
        @include('components.footer')

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE JS -->
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.0/dist/js/adminlte.min.js"></script>
    </div>
</body>

</html>