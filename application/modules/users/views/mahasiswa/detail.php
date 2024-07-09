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

        <!-- Top Buttons Start -->
        <div class="col-12 col-md-5 d-flex align-items-end justify-content-end">
            <button type="button" class="btn btn-outline-primary btn-icon btn-icon-start ms-0 ms-sm-1 w-100 w-md-auto">
                <i data-acorn-icon="save"></i>
                <span>Update</span>
            </button>

            <!-- Dropdown Button Start -->
            <div class="ms-1">
                <button
                    type="button"
                    class="btn btn-outline-primary btn-icon btn-icon-only"
                    data-bs-offset="0,3"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                    data-submenu>
                    <i data-acorn-icon="more-horizontal"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <button class="dropdown-item" type="button">Edit</button>
                    <button class="dropdown-item" type="button">View Purchases</button>
                    <button class="dropdown-item" type="button">Check Ip</button>
                </div>
            </div>
            <!-- Dropdown Button End -->
        </div>
        <!-- Top Buttons End -->

    </div>
</div>
<!-- Title and Top Buttons End -->

<div class="row gx-4 gy-2">
    <ul class="nav nav-tabs separator-tabs ml-0 mb-5" role="tablist">
    <li class="nav-item">
            <a class="nav-link active" id="first-tab" data-bs-toggle="tab" href="#first" role="tab"
                aria-controls="first" aria-selected="true">PROFILE</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="second-tab" data-bs-toggle="tab" href="#second" role="tab"
                aria-controls="second" aria-selected="false">DATA BERKAS</a>
        </li>

        <li class="nav-item">
            <a class="nav-link" id="three-tab" data-bs-toggle="tab" href="#three" role="tab"
                aria-controls="three" aria-selected="false">DATA KRS</a>
        </li>

    </ul>

    <div class="tab-content">

        <div class="tab-pane show active" id="first" role="tabpanel" aria-labelledby="first-tab">
            <div class="row">
                <div class="col-12 col-xl-4 col-xxl-3">
                    <div class="card" style="position:-webkit-sticky; position: sticky; top: 3rem;">

                        <div class="card-body mb-n5">

                            <div class="d-flex align-items-center flex-column">
                                <div class="mb-2 d-flex align-items-center flex-column">
                                    <?php if(!empty($data_mhs['foto_profil'])){ ?>
                                            <a data-fancybox="foto-profil" data-src="<?= base_url('upload/berkas/'.$data_mhs['no_pendaftaran'].'/foto/'.$data_mhs['foto_profil']) ?>" >
                                                <img src="<?= base_url('upload/berkas/'.$data_mhs['no_pendaftaran'].'/foto/'.$data_mhs['foto_profil']) ?>" class="img-fluid rounded-xl mb-2" alt="thumb" />
                                            </a>
                                    <?php } else { ?>
                                            <a data-fancybox="foto-profil" data-src="<?= base_url('assets/') ?>img/profile/profile.webp" >
                                                <img src="<?= base_url('assets/') ?>img/profile/profile.webp" class="img-fluid rounded-xl mb-2" alt="thumb" />
                                            </a>
                                    <?php } ?>

                                    <div class="h5 text-black text-center mb-1"><b><?= $data_mhs['nim'] ?></b></div>
                                    <div class="h4 text-black text-center mb-1"><?= capital($data_mhs['nama_mhs']) ?></div>
                                    <div class="h6 text-black text-center mb-1"><b>Semester <?= $smt_aktif['zem'] ?></b></div>

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
                                        <div class="col text-medium text-black"><b> <?= $data_mhs['no_hp'] ?> </b></div>
                                    </div>
                                    <div class="row g-0 mb-1">
                                        <div class="col-auto">
                                            <div class="sw-3 me-1">
                                                <i data-acorn-icon="email" class="text-primary" data-acorn-size="17"></i>
                                            </div>
                                        </div>
                                        <div class="col text-black"><b><?= $data_mhs['email'] ?></b></div>
                                    </div>

                                    <div class="row g-0 mb-1">
                                        <div class="col-auto">
                                            <div class="sw-3 me-1">
                                                <i data-acorn-icon="pin" class="text-primary" data-acorn-size="17"></i>
                                            </div>
                                        </div>
                                        <div class="col text-black"><?= $data_mhs['alamat'] ?></div>
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

        <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
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

        <div class="tab-pane fade" id="three" role="tabpanel" aria-labelledby="three-tab">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card d-flex flex-row mb-4">
                        <div class="card-body">
                            <?php $this->load->view('3matkul') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>