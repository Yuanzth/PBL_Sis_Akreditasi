<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk Sistem</title>

    <!-- Google Font: Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- Custom CSS for Background and Form -->
    <style>
        .login-page {
            background: url('{{ asset('loginn/Login.png') }}') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.5s ease;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .login-box {
            position: relative;
            z-index: 2;
            background: rgba(224, 242, 241, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .login-logo {
            display: block;
            margin: 0 auto 15px;
            max-width: 100px;
            height: auto;
        }

        .login-box-msg {
            margin-bottom: 20px;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #333;
            text-align: left;
            display: block;
            font-family: 'Poppins', sans-serif;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .error-text {
            display: block;
            margin-top: 5px;
            font-family: 'Poppins', sans-serif;
        }

        .btn-block {
            border-radius: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .row {
            justify-content: center;
            margin-top: 10px;
        }

        .col-4 {
            flex: 0 0 100px;
            max-width: 100px;
        }

        .bg-selector {
            margin-bottom: 20px;
            padding: 5px;
            border-radius: 5px;
            width: 200px;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card-body">
            <img src="{{ asset('loginn/logo_jti.png') }}" alt="JTI Logo" class="login-logo">
            <h2 class="login-box-msg"><b>Masuk Sistem</b></h2>
            <p class="login-box-msg">Masukkan username dan password yang terdaftar di sistem</p>

            <form action="{{ url('login') }}" method="POST" id="form-login">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username">
                        <div class="input-group-append"></div>
                    </div>
                    <small id="error-username" class="error-text text-danger"></small>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password">
                        <div class="input-group-append"></div>
                    </div>
                    <small id="error-password" class="error-text text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-4">
                        <button type="button" class="btn btn-danger btn-block" onclick="window.location.href='{{ url('/home/') }}'">Back</button>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- jquery-validation -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function changeBackground(type) {
            const loginPage = document.querySelector('.login-page');
            switch (type) {
                case 'gradient':
                    loginPage.style.background = 'linear-gradient(135deg, #26a69a, #00695c)';
                    loginPage.style.backgroundImage = 'radial-gradient(circle at 20% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 70%), radial-gradient(circle at 80% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 70%)';
                    break;
                case 'solid':
                    loginPage.style.background = '#1976d2';
                    loginPage.style.backgroundImage = 'none';
                    break;
                case 'image':
                    loginPage.style.background = `url('{{ asset('loginn/Login.png') }}') no-repeat center center fixed`;
                    loginPage.style.backgroundSize = 'cover';
                    loginPage.style.backgroundImage = 'none';
                    break;
            }
        }

        $(document).ready(function() {
            $("#form-login").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 5,
                        maxlength: 20
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 401) {
                                // Error autentikasi (username/password salah)
                                $('.error-text').text('');
                                const response = xhr.responseJSON;
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            } else {
                                // Error server lainnya
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: 'Gagal menghubungi server. Silakan coba lagi.'
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').find('.error-text').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>