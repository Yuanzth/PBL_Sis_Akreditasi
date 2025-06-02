<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Footer SIB</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f8f8f8;
    }

    footer.footer {
      background-color: #ffffff;
      padding: 50px 80px 0;
    }

    .footer .container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      align-items: flex-start;
    }

    .footer-left {
      max-width: 55%;
    }

    .logo-row {
      display: flex;
      align-items: center;
      gap: 18px;
      margin-bottom: 15px;
    }

    .logo-row img {
      height: 60px;
    }

    .address {
      font-size: 14px;
      line-height: 1.7;
      color: #333;
    }

    .telepon {
      margin-top: 30px;
      margin-bottom: 30px;
    }

    .telepon i {
      margin-right: 8px;
      color: #0B6B4F;
    }

    .footer-right {
      text-align: right;
    }

    .footer-right h4 {
      font-size: 16px;
      margin-bottom: 10px;
      color: #222;
    }

    .social-icons img {
      width: 24px;
      height: 24px;
      margin-left: 14px;
      vertical-align: middle;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .social-icons img:hover {
      transform: scale(1.1);
    }

    .footer-bottom {
      background-color: #0B6B4F;
      color: white;
      padding: 18px 80px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      font-size: 14px;
      width: 100vw;
      margin-left: calc(-50vw + 50%);
      box-sizing: border-box;
    }

    .footer-bottom .links a {
      color: white;
      text-decoration: none;
      margin-left: 25px;
    }

    .footer-bottom .links a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .footer .container {
        flex-direction: column;
        gap: 30px;
      }

      .footer-right {
        text-align: left;
      }

      .footer-bottom {
        flex-direction: column;
        gap: 10px;
        text-align: center;
        padding: 18px 20px;
      }

      .footer-bottom .links a {
        margin: 0 10px;
      }
    }
  </style>
</head>
<body>

  <footer class="footer">
    <div class="container">
      <div class="footer-left">
        <div class="logo-row">
          <img src="{{ asset('landing_page/logo/Logo Polinema 4.png') }}" alt="Polinema">
          <img src="{{ asset('landing_page/logo/logo_jti.png') }}" alt="JTI">
        </div>
        <div class="address">
          <strong>Politeknik Negeri Malang</strong><br>
          Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru,<br>
          Kota Malang, Jawa Timur 65141<br>
          <div class="telepon"><i class="bi bi-telephone"></i>(0341) 404424</div>
        </div>
      </div>

      <div class="footer-right">
        <h4>Social Media:</h4>
        <div class="social-icons">
          <img src="{{ asset('landing_page/icons/icon_instagram.png') }}" alt="Instagram">
          <img src="{{ asset('landing_page/icons/icon_gmail.png') }}" alt="Gmail">
          <img src="{{ asset('landing_page/icons/icon_facebook.png') }}" alt="Facebook">
          <img src="{{ asset('landing_page/icons/icon_x.png') }}" alt="X">
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div>© Kelompok 3 SIB 2A – All rights reserved</div>
      <div class="links">
        <a href="#">Terms & Condition</a>
        <a href="#">Privacy Policy</a>
        <a href="#">Contact us</a>
      </div>
    </div>
  </footer>

</body>
</html>