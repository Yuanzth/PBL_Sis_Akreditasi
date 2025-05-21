<link rel="stylesheet" href="{{ asset('landing-custom.css') }}">

<!-- Section Tujuan dengan Carousel (Rounded Square) -->
<div class="section section-visi-misi" style="height: 85vh; background: url('{{ asset('landing_page/background/landing_page_tujuan_prodi.png') }}') no-repeat top center; background-size: cover; margin-top: 0; padding-top: 0;">
    <div class="container" style="padding-top: 50px;">
        <h2 class="text-center mb-5" style="color: #0B6B4F; font-weight: bold;">Tujuan Prodi Sistem Informasi Bisnis
        </h2>
        <p class="text-justify mb-5" style="font-size: 1rem; color: #333;">
            Politeknik Negeri Malang memiliki tujuan untuk mewujudkan lulusan berkompeten, mengembangkan penelitian
            terapan, memperkuat pengabdian masyarakat, dan membangun kerja sama di bidang sistem informasi bisnis.
        </p>
        <div class="row d-flex justify-content-center align-items-center">

            <!-- Carousel Rounded Square -->
            <div class="col-md-6 d-flex justify-content-center">
                <div id="tujuanCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('landing_page/images/image_profile_polinema.jpeg') }}"
                                class="d-block w-100 rounded-3" alt="Image 1"
                                style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('landing_page/images/img_lab.jpg') }}" class="d-block w-100 rounded-3"
                                alt="Image 2" style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('landing_page/images/img_prestasi_2.jpg') }}"
                                class="d-block w-100 rounded-3" alt="Image 3"
                                style="width: 400px; height: 400px; object-fit: cover;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#tujuanCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#tujuanCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Kartu Tujuan -->
            <div class="col-md-6 d-flex justify-content-center mb-4">
                <div class="card border-0 rounded-0" style="background-color: rgba(119, 208, 130, 0.2); border-left: 5px solid #007BFF; width: 400px; height: 400px;">
                    <div class="card-body p-4" style="overflow-y: auto; height: 100%;">
                        <p class="card-text" style="font-size: 0.9rem;">
                            1. Menghasilkan lulusan yang kompeten dan profesional dalam bidang sistem informasi bisnis
                            yang mampu bersaing di tingkat nasional dan internasional.<br>
                            2. Mengembangkan penelitian terapan di bidang sistem informasi bisnis yang mendukung
                            kebutuhan industri dan masyarakat.<br>
                            3. Memberikan kontribusi nyata melalui pengabdian masyarakat berbasis teknologi informasi
                            untuk meningkatkan kesejahteraan.<br>
                            4. Menjalin kerjasama strategis dengan berbagai pihak untuk mendukung pengembangan program
                            studi dan lulusan.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
