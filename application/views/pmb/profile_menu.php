<!-- Left Side Start -->
<div class="col-12 col-xl-4 col-xxl-3">
    <div class="card mb-5">
        <div class="card-body">
            <div class="d-flex align-items-center flex-column mb-4">
                <div class="d-flex align-items-center flex-column">
                    <div class="sw-13 position-relative mb-3">

                    <?php if(!empty($pmb['foto_profil'])){ ?>
                        <img src="<?= base_url('upload/berkas/'.$pmb['no_pendaftaran'].'/foto/'.$pmb['foto_profil']) ?>" class="img-fluid rounded-xl" alt="thumb" />
                    <?php } else { ?>
                        <img src="<?= base_url('assets/') ?>img/profile/profile.webp" class="img-fluid rounded-xl" alt="thumb" />
                    <?php } ?>

                    </div>
                    <div class="h5 mb-0"><b><?= capital($pmb['nama']) ?></b></div>
                    <div class="text-black"><?= $this->session->userdata('username') ?></div>
                    <div class="text-muted">
                        <i data-acorn-icon="pin" class="me-1"></i>
                        <span class="align-middle"><?= $pmb['no_pendaftaran'] ?></span>
                    </div>
                </div>
            </div>

            <?php $status = $pmb['status_terkini']; ?>
            <div class="nav flex-column" role="tablist">
                <a class="nav-link <?php if($status=='1'){ echo 'active';} ?>  px-0 border-bottom border-separator-light" data-bs-toggle="tab"
                    href="#statusTerkiniTab" role="tab">
                    <i data-acorn-icon="activity" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Status Terkini</span>
                </a>
                <a class="nav-link <?php if($status=='2'){ echo 'active';} ?> px-0 border-bottom border-separator-light" data-bs-toggle="tab"
                    href="<?php if($status >= '1' ){ echo '#biodataTab';} ?>" role="tab">
                    <i data-acorn-icon="user" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Biodata Pendaftar</span>
                </a>
                <a class="nav-link <?php if($status=='3'){ echo 'active';} ?> px-0 border-bottom border-separator-light" data-bs-toggle="tab"
                    href="<?php if($status >= '3'){ echo '#uploadFotoTab';} ?>" role="tab">
                    <i data-acorn-icon="image" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Upload Foto</span>
                </a>
                <a class="nav-link <?php if($status=='4'){ echo 'active';} ?> px-0 border-bottom border-separator-light" data-bs-toggle="tab"
                    href="<?php if($status >='4'){ echo '#uploadBerkasTab';} ?>" role="tab">
                    <i data-acorn-icon="form" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Upload Berkas</span>
                </a>
                <a class="nav-link <?php if($status=='5'){ echo 'active';} ?> px-0" data-bs-toggle="tab"
                    href="<?php if($status >='5'){ echo '#pembayaranTagihanTab';} ?>" role="tab">
                    <i data-acorn-icon="credit-card" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Pembayaran Tagihan</span>
                </a>
                <a class="nav-link <?php if($status=='6'){ echo 'active';} ?> px-0" data-bs-toggle="tab"
                    href="<?php if($status >='6'){ echo '#finalisasiDataTab';} ?>" role="tab">
                    <i data-acorn-icon="shield-check" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Finalisasi Data</span>
                </a>
                <hr>
                <a class="nav-link px-0" data-bs-toggle="tab" href="#aboutTab" role="tab">
                    <i data-acorn-icon="form-check" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Jadwal & Test Seleksi</span>
                </a>
                <a class="nav-link px-0" data-bs-toggle="tab" href="#aboutTab" role="tab">
                    <i data-acorn-icon="print" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Cetak Kartu Ujian</span>
                </a>
                <a class="nav-link px-0" data-bs-toggle="tab" href="#aboutTab" role="tab">
                    <i data-acorn-icon="print" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Cetak Form Pendaftaran</span>
                </a>
                <a class="nav-link px-0" data-bs-toggle="tab" href="#aboutTab" role="tab">
                    <i data-acorn-icon="invoice" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Riwayat Pembayaran</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Biography End -->
</div>
<!-- Left Side End -->