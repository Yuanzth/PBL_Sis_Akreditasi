<div id="profile" class="section section-profile bg-light py-5">
    <div class="container">
        <h2 class="text-left mb-5" style="color: #0B6B4F; font-weight: bold;">Profile Polinema</h2>
        <div class="row align-items-start">
            <!-- Text -->
            <div class="col-md-6">
                <div id="profile-content" style="max-height: 400px; overflow-y: auto; padding: 15px;">
                    <p class="mb-3 text-justify initial-text" style="font-size: 1rem;">
                        Berawal dari Fakultas Non-Gelar Teknologi Universitas Brawijaya yang beroperasi setelah
                        disahkannya Surat Keputusan Presiden Republik Indonesia Nomor 59 Tahun 1982, Politeknik Negeri
                        Malang saat ini telah berkembang menjadi institusi pendidikan vokasi mandiri. Perubahan status
                        tersebut tercantum dalam Surat Keputusan Menteri Pendidikan dan Kebudayaan Nomor 0313/O/1991.
                        Politeknik Negeri Malang terus berupaya melakukan perubahan ke arah perbaikan, khususnya dalam
                        bidang pendidikan, penelitian, dan pengabdian kepada masyarakat yang berorientasi pada teknologi
                        terapan.
                    </p>
                    <p class="mb-3 text-justify additional-text" style="font-size: 1rem; display: none;">
                        Upaya tersebut menunjukkan hasil positif, yang dibuktikan dengan pencapaian akreditasi A pada
                        tahun 2018 (SK Nomor 409/SK/BAN-PT/Akred/PT/XII/2018) dan akreditasi internasional ASIC
                        (Accreditation Service for International Schools, Colleges, and Universities) pada tahun 2020
                        untuk 20 program studi.<br><br>
                        Program studi D4 Sistem Informasi Bisnis (D4-SIB) didirikan pada tahun 2010 berdasarkan Surat
                        Keputusan Menteri Pendidikan Nasional Nomor 50/D/O/2010. Pada awal berdirinya, program studi
                        D4-SIB berada di bawah Jurusan Teknik Elektro, Politeknik Negeri Malang. Kemudian, mulai tahun
                        2015, setelah didirikannya Jurusan Teknologi Informasi, program studi D4-SIB beralih ke jurusan
                        tersebut. Pada tahun 2018, program studi D4-SIB memperoleh peringkat akreditasi B dari BAN-PT
                        berdasarkan SK Nomor 1810/SK/BAN-PT/Akred/Dipl-IV/VII/2018.
                    </p>
                </div>
                <div class="text-left mt-4">
                    <a href="#profile-content" class="btn text-white rounded-pill px-4 py-2 read-more"
                        style="background-color: #0B6B4F;">Selengkapnya</a>
                </div>
            </div>

            <!-- Carousel-->
            <div class="col-md-6">
                <div id="profileCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('landing_page/images/image_profile_polinema.jpeg') }}"
                                class="d-block w-100 rounded-3" alt="Polinema Building 1"
                                style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('landing_page/images/img_lab.jpg') }}"
                                class="d-block w-100 rounded-3" alt="Polinema Building 2"
                                style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('landing_page/images/img_prestasi_2.jpg') }}"
                                class="d-block w-100 rounded-3" alt="Polinema Building 3"
                                style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#profileCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#profileCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const readMoreBtn = document.querySelector('.read-more');
        const additionalText = document.querySelector('.additional-text');

        readMoreBtn.addEventListener('click', function (e) {
            e.preventDefault();
            additionalText.style.display = 'block';
            this.style.display = 'none';
            document.querySelector('#profile-content').scrollIntoView({ behavior: 'smooth' });
        });
    });
</script>