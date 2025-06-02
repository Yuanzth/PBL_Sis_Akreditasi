<link rel="stylesheet" href="{{ asset('landing-custom.css') }}">

<!-- Section Sasaran -->
<section id="sasaran" class="section" style="padding: 60px 0; background-color: #F9F9F9;">
    <div class="container">
        <h2 class="text-center mb-3" style="color: #0B6B4F; font-weight: bold;">Sasaran</h2>
        <p class="text-center mb-5" style="color: #333;">
            Program Studi Sistem Informasi Bisnis menetapkan sasaran untuk mewujudkan visi sebagai program studi unggul dan mendukung misi pendidikan vokasi yang inovatif dan adaptif teknologi.
        </p>

        <div class="row">
            <!-- Kolom Gambar Gedung -->
            <div class="col-md-6 mb-4 text-center">
                <img src="{{ asset('landing_page/images/image_sasaran_1.png') }}" alt="Gedung 1" class="img-fluid mb-3 rounded"
                     style="max-width: 68%; max-height: 350px; height: auto;">
                <img src="{{ asset('landing_page/images/image_sasaran_2.png') }}" alt="Gedung 2" class="img-fluid rounded"
                     style="max-width: 68%; max-height: 350px; height: auto;">
            </div>

            <!-- Kolom Daftar Sasaran -->
            <div class="col-md-6">
                @for ($i = 1; $i <= 5; $i++)
                <div class="d-flex shadow-sm p-3 mb-3 bg-white rounded align-items-center">
                    <!-- Ikon -->
                    <div class="d-flex justify-content-center align-items-center"
                         style="min-width: 60px; min-height: 60px; background-color: #0B6B4F; border-radius: 4px;">
                        <img src="{{ asset('landing_page/icons/icon_sasaran_' . $i . '.png') }}"
                             alt="Icon {{ $i }}" style="width: 30px; height: 30px;">
                    </div>

                    <!-- Teks Sasaran -->
                    <div class="ms-3" style="font-size: 0.9rem; color: #333;">
                        @switch($i)
                            @case(1)
                                1. Meningkatnya akses relevansi, kuantitas, dan kualitas Pendidikan Program Studi D4 – SIB.
                                @break
                            @case(2)
                                2. Meningkatnya relevansi dan kualitas kegiatan pembelajaran di Program Studi D4 – SIB.
                                @break
                            @case(3)
                                3. Meningkatnya kualitas hasil kegiatan kemahasiswaan D4 – SIB dan inisiasi pembinaan karier untuk pembekalan lulusan.
                                @break
                            @case(4)
                                4. Meningkatnya relevansi, kuantitas, kualitas, dan kemanfaatan hasil penelitian seluruh sivitas akademika.
                                @break
                            @case(5)
                                5. Meningkatnya relevansi, kuantitas, kualitas, dan kemanfaatan hasil pengabdian kepada masyarakat untuk kesejahteraan masyarakat.
                                @break
                        @endswitch
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</section>
