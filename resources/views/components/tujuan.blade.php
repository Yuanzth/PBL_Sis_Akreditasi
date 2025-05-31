<link rel="stylesheet" href="{{ asset('landing-custom.css') }}">

<!-- Section Tujuan dengan Carousel (Rounded Square) -->
<div class="section section-visi-misi" style="background: url('{{ asset('landing_page/background/landing_page_tujuan_prodi.png') }}') no-repeat top center; background-size: cover; margin-top: 0; padding-top: 0; padding-bottom: 50px;">
    <div class="container pt-5">
        <h2 class="text-center mb-5" style="color: #0B6B4F; font-weight: bold;">Tujuan Prodi Sistem Informasi Bisnis</h2>
        <p class="text-justify mb-5" style="font-size: 1rem; color: #333;">
            Politeknik Negeri Malang memiliki tujuan untuk mewujudkan lulusan berkompeten, mengembangkan penelitian
            terapan, memperkuat pengabdian masyarakat, dan membangun kerja sama di bidang sistem informasi bisnis.
        </p>

        <div class="row gx-4 align-items-stretch">
            <!-- Carousel Column -->
            <div class="col-md-6 d-flex">
                <div class="w-100 tujuan-box">
                    <div id="tujuanCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">
                            <div class="carousel-item active h-100">
                                <img src="{{ asset('landing_page/images/image_profile_polinema.jpeg') }}"
                                     class="d-block w-100 h-100 rounded-3 object-fit-cover" alt="Image 1">
                            </div>
                            <div class="carousel-item h-100">
                                <img src="{{ asset('landing_page/images/img_lab.jpg') }}"
                                     class="d-block w-100 h-100 rounded-3 object-fit-cover" alt="Image 2">
                            </div>
                            <div class="carousel-item h-100">
                                <img src="{{ asset('landing_page/images/img_prestasi_2.jpg') }}"
                                     class="d-block w-100 h-100 rounded-3 object-fit-cover" alt="Image 3">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#tujuanCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#tujuanCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card Column -->
            <div class="col-md-6 d-flex">
                <div class="card tujuan-box border-0 rounded-0" style="background-color: rgba(119, 208, 130, 0.2); border-left: 5px solid #007BFF;">
                    <div class="card-body p-4 overflow-auto">
                        <p class="card-text" style="font-size: 0.9rem;">
                            1. Menghasilkan <b>lulusan</b> bidang sistem informasi bisnis yang sesuai kebutuhan, beretika dan bermoral baik, berpengetahuan dan berketerampilan tinggi, siap bekerja dan/atau berwirausaha yang mampu bersaing dalam skala nasional dan global;<br><br>
                            2. Menghasilkan <b>penelitian</b> terapan bidang sistem informasi bisnis yang berskala nasional dan internasional, meningkatkan efektivitas, efisiensi, dan produktivitas dalam dunia usaha dan industri, serta mengarah pada pencapaian Hak atas Kekayaan Intelektual (HaKI), perolehan paten, dan kesejahteraan masyarakat;<br><br>
                            3. Menghasilkan <b>pengabdian</b> kepada masyarakat yang dilaksanakan melalui penerapan dan penyebarluasan ilmu pengetahuan dan teknologi serta pemberian layanan hasil secara profesional dalam bidang sistem informasi bisnis sehingga bermanfaat secara langsung dalam meningkatkan kesejahteraan masyarakat;<br><br>
                            4. Menghasilkan sistem <b>manajemen</b> pendidikan bidang sistem informasi bisnis yang memenuhi prinsip-prinsip tata kelola yang baik;<br><br>
                            5. Terwujudnya <b>kerja sama</b> yang saling menguntungkan dengan berbagai pihak baik di dalam maupun di luar negeri pada bidang sistem informasi bisnis untuk meningkatkan daya saing.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>