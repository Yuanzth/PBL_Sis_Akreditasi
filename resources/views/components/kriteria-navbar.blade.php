<!-- components/kriteria-navbar.blade.php -->
<section class="navbar-section">
    <div class="container-fluid px-5 pt-0 pb-0">
        <div class="d-flex justify-content-between align-items-center mt-0 pt-3">
            <a href="/" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('landing_page/logo/logo_jti.png') }}" alt="JTI Logo" class="logo-jti">
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="/home" class="nav-link-custom">Beranda</a>
                <a href="https://jti.polinema.ac.id" class="nav-link-custom">Website Polinema</a>

                <!-- Dropdown Denah Gedung -->
                <div class="dropdown">
                    <a class="nav-link-custom dropdown-toggle" href="#" role="button" id="denahGedungDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Denah Gedung
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="denahGedungDropdown">
                        <li><a class="dropdown-item" href="https://my.matterport.com/show/?m=xufa7UrDLJe">Lantai 5</a></li>
                        <li><a class="dropdown-item" href="https://my.matterport.com/show/?m=Fj8fbnjLjQq">Lantai 6</a></li>
                        <li><a class="dropdown-item" href="https://my.matterport.com/show/?m=fAgiViGeZaB">Lantai 7</a></li>
                    </ul>
                </div>

                <!-- Dropdown Kriteria -->
                <div class="dropdown">
                    <a class="nav-link-custom dropdown-toggle" href="#" role="button" id="kriteriaDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Kriteria
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="kriteriaDropdown">
                        @for($i = 1; $i <= 9; $i++)
                            <li><a class="dropdown-item" href="{{ route('home.kriteria', $i) }}">Kriteria {{ $i }}</a></li>
                        @endfor
                    </ul>
                </div>

                <a href="/login"
                    class="btn btn-light text-success font-weight-bold px-4 py-2 rounded-pill login-btn">Login</a>
            </div>
        </div>
    </div>
</section>