<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akreditasi SIB</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1 0 auto;
        }

        .footer {
            flex-shrink: 0;
            background-color: #f8f9fa;
            padding: 150px 0;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .col-md-6 {
            width: 48%;
            text-align: left;
        }

        .mt-3 {
            margin-top: 1rem;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('landing_page/logo/Logo Polinema 4.png') }}" alt="Polinema Logo" style="width: 50px;">
                    <img src="{{ asset('landing_page/logo/logo_jti.png') }}" alt="JTI Logo" style="width: 50px;">
                    <p>Politeknik Negeri Malang<br>Jl. Soekarno Hatta No. 9, Jatimulyo, Kec. Lowokwaru,<br>Kota Malang, Jawa Timur 65141<br>© (0341) 404424</p>
                </div>
                <div class="col-md-6">
                    <p>Social Media:<br>
                        <img src="{{ asset('landing_page/icons/icon_facebook.png') }}" alt="Facebook" style="width: 24px; margin-right: 10px;">
                        <img src="{{ asset('landing_page/icons/icon_gmail.png') }}" alt="Gmail" style="width: 24px; margin-right: 10px;">
                        <img src="{{ asset('landing_page/icons/icon_instagram.png') }}" alt="Instagram" style="width: 24px;">
                    </p>
                </div>
            </div>
            <p class="mt-3">© Sistem Akreditasi SIB - All rights reserved</p>
            <p><a href="#">Terms & Condition</a> | <a href="#">Privacy Policy</a> | <a href="#">Contact us</a></p>
        </div>
    </footer>
</body>
</html>