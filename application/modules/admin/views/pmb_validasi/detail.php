<!-- Title and Top Buttons Start -->
<div class="page-title-container">
    <div class="row">
        <!-- Title Start -->
        <div class="col-auto mb-3 mb-md-0 me-auto">
            <div class="w-auto sw-md-50">
                <a href="<?= base_url(lowercase($modul).'/'.lowercase($pagetitle)); ?>" class="muted-link pb-1 d-inline-block breadcrumb-back">
                    <i data-acorn-icon="chevron-left" data-acorn-size="13"></i>
                    <span class="text-small align-middle"> <?= $pagetitle ?></span>
                </a>
                <h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?> Detail</h1>
            </div>
        </div>
        <!-- Title End -->

    </div>
</div>
<!-- Title and Top Buttons End -->

<div class="row gx-4 gy-2">
    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="second-tab" data-bs-toggle="tab" href="#second" role="tab"
                aria-controls="second" aria-selected="false">DATA VALIDASI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="first-tab" data-bs-toggle="tab" href="#first" role="tab"
                aria-controls="first" aria-selected="true">PROFILE</a>
        </li>
    </ul>

    <?php $this->load->view('templates/notif') ?>

    <div class="tab-content">
        <div class="tab-pane " id="first" role="tabpanel" aria-labelledby="first-tab">
            <div class="row">
                <div class="col-12 col-xl-4 col-xxl-3">
                    <div class="card" style="position:-webkit-sticky; position: sticky; top: 3rem;">

                        <div class="card-body mb-n5">

                            <div class="d-flex align-items-center flex-column">
                                <div class="mb-2 d-flex align-items-center flex-column">
                                    <?php if(!empty($pmb_validasi['foto_profil'])){ ?>
                                        <a data-fancybox="foto-profil" data-src="<?= base_url('upload/berkas/'.$pmb_validasi['no_pendaftaran'].'/foto/'.$pmb_validasi['foto_profil']) ?>" >
                                            <img src="<?= base_url('upload/berkas/'.$pmb_validasi['no_pendaftaran'].'/foto/'.$pmb_validasi['foto_profil']) ?>" class="img-fluid rounded-xl mb-2" alt="thumb" />
                                        </a>
                                    <?php } else { ?>
                                        <a data-fancybox="foto-profil" data-src="<?= base_url('assets/') ?>img/profile/profile.webp" >
                                            <img src="<?= base_url('assets/') ?>img/profile/profile.webp" class="img-fluid rounded-xl mb-2" alt="thumb" />
                                        </a>
                                    <?php } ?>

                                    <div class="h5 text-black text-center mb-1"><b><?= $pmb_validasi['no_pendaftaran'] ?></b></div>
                                    <div class="h4 text-black text-center mb-1"><?= capital($pmb_validasi['nama']) ?></div>

                                </div>
                            </div>

                            <div class="mb-2">
                                <div>
                                    <div class="row g-0 mb-1">
                                        <div class="col-auto">
                                            <div class="sw-3 me-1">
                                                <i data-acorn-icon="phone" class="text-primary" data-acorn-size="17"></i>
                                            </div>
                                        </div>
                                        <div class="col text-medium text-black"><b> <?= $pmb_validasi['no_hp'] ?> </b></div>
                                    </div>
                                    <div class="row g-0 mb-1">
                                        <div class="col-auto">
                                            <div class="sw-3 me-1">
                                                <i data-acorn-icon="email" class="text-primary" data-acorn-size="17"></i>
                                            </div>
                                        </div>
                                        <div class="col text-black"><b><?= $pmb_validasi['email'] ?></b></div>
                                    </div>

                                    <div class="row g-0 mb-1">
                                        <div class="col-auto">
                                            <div class="sw-3 me-1">
                                                <i data-acorn-icon="pin" class="text-primary" data-acorn-size="17"></i>
                                            </div>
                                        </div>
                                        <div class="col text-black"><?= $pmb_validasi['alamat'] ?></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-8 col-xxl-9">
                    <!-- Activity Start -->
                    <div class="card mb-5">
                        <div class="card-body">


                            <?php $this->load->view('1biodata') ?>

                        </div>
                    </div>
                    <!-- Activity End -->
                </div>
            </div>
        </div>

        <div class="tab-pane fade show active" id="second" role="tabpanel" aria-labelledby="second-tab">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card d-flex flex-row mb-4">
                        <div class="card-body">
                            <?php $this->load->view('2berkas') ?>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>


</div>