<!-- Left Side Start -->
<div class="col-12 col-xl-4 col-xxl-3">
    <div class="card mb-5">
        <div class="card-body">
            <div class="d-flex align-items-center flex-column mb-4">
                <div class="d-flex align-items-center flex-column">
                    <div class="sw-13 position-relative mb-3">
                        <img src="<?= base_url('assets/') ?>img/profile/profile-2.webp" class="img-fluid rounded-xl" alt="thumb" />
                    </div>
                    <div class="h5 mb-0"><?= capital($this->session->userdata('name')) ?></div>
                    <div class="text-muted"><?= $this->session->userdata('username') ?></div>
                    <div class="text-muted">
                        <i data-acorn-icon="pin" class="me-1"></i>
                        <span class="align-middle">Montreal, Canada</span>
                    </div>
                </div>
            </div>
            <div class="nav flex-column" role="tablist">
                <a class="nav-link active px-0 border-bottom border-separator-light" data-bs-toggle="tab" href="#statusTerkiniTab" role="tab">
                    <i data-acorn-icon="activity" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Status Terkini</span>
                </a>
                <a class="nav-link px-0 border-bottom border-separator-light" data-bs-toggle="tab" href="#projectsTab" role="tab">
                    <i data-acorn-icon="user" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Biodata Pendaftar</span>
                </a>
                <a class="nav-link px-0 border-bottom border-separator-light" data-bs-toggle="tab" href="#permissionsTab" role="tab">
                    <i data-acorn-icon="image" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Upload Foto</span>
                </a>
                <a class="nav-link px-0 border-bottom border-separator-light" data-bs-toggle="tab" href="#friendsTab" role="tab">
                    <i data-acorn-icon="form" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Upload Berkas</span>
                </a>
                <a class="nav-link px-0" data-bs-toggle="tab" href="#aboutTab" role="tab">
                    <i data-acorn-icon="credit-card" class="me-2" data-acorn-size="17"></i>
                    <span class="align-middle">Pembayaran Tagihan</span>
                </a>
                <a class="nav-link px-0" data-bs-toggle="tab" href="#aboutTab" role="tab">
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