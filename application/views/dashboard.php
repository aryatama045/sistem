

    <!-- Title and Top Buttons Start -->
    <div class="page-title-container">
        <div class="row">
            <!-- Title Start -->
            <div class="col-12 col-md-7">
                <a class="muted-link pb-2 d-inline-block hidden" href="#">
                    <span class="align-middle lh-1 text-small">&nbsp;</span>
                </a>
                <h1 class="mb-0 pb-0 display-4" id="title">Welcome, <?= $this->session->userdata('username'); ?> ! <br>
                    <span class="text-small text-muted">Tahun Ajaran : <?= $tahun_ajaran ?> - Semeseter <?= $semester ?></span></h1>
            </div>
            <!-- Title End -->
        </div>
    </div>
    <!-- Title and Top Buttons End -->

    <hr>

    <!-- Stats Start -->
    <div class="row">
        <div class="col-12">
            <div class="mb-5">
                <div class="row g-2">
                    <div class="col-auto mb-5">
                        <div class="card w-100 sw-sm-50 sh-19 hover-img-scale-up">
                            <img src="<?= base_url('assets/'); ?>img/banner/cta-horizontal-short-1.webp" class="card-img h-100 scale" alt="card image" />
                            <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                                <div style="background-color: #fffffff0;padding: 1px 9px 6px 16px;border-radius: 13px;">
                                    <div class="cta-1 mb-3 mt-1 text-black w-75 w-md-100">Penerimaan Mahasiswa Baru</div>
                                    <a href="#" class="btn btn-icon btn-icon-start btn-primary stretched-link">
                                        <i data-acorn-icon="chevron-right"></i>
                                        <span>PMB</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto mb-5">
                        <div class="card w-100 sw-sm-50 sh-19 hover-img-scale-up">
                            <img src="<?= base_url('assets/'); ?>img/banner/cta-horizontal-short-1.webp" class="card-img h-100 scale" alt="card image" />
                            <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                                <div style="background-color: #fffffff0;padding: 1px 9px 6px 16px;border-radius: 13px;">
                                    <div class="cta-1 mb-3 mt-1 text-black w-75 w-md-100">Penerimaan Mahasiswa Baru</div>
                                    <a href="#" class="btn btn-icon btn-icon-start btn-primary stretched-link">
                                        <i data-acorn-icon="chevron-right"></i>
                                        <span>PMB</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="arrow-top-left" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">RETURNS</div>
                            <div class="text-primary cta-4">2</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="message" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">COMMENTS</div>
                            <div class="text-primary cta-4">5</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="message" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">COMMENTS</div>
                            <div class="text-primary cta-4">5</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="message" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">COMMENTS</div>
                            <div class="text-primary cta-4">5</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="message" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">COMMENTS</div>
                            <div class="text-primary cta-4">5</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card h-100 hover-scale-up cursor-pointer">
                            <div class="card-body d-flex flex-column align-items-center">
                            <div class="sw-6 sh-6 rounded-xl d-flex justify-content-center align-items-center border border-primary mb-4">
                                <i data-acorn-icon="message" class="text-primary"></i>
                            </div>
                            <div class="mb-1 d-flex align-items-center text-alternate text-small lh-1-25">COMMENTS</div>
                            <div class="text-primary cta-4">5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats End -->

    <script src="<?= base_url('assets/') ?>js/base/searchD.js"></script>
