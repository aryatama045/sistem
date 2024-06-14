

    <h4>Data Diri</h4> <hr class="mb-2">
    <!-- No Daftar & Tanggal -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control"><b><?= $dosen['nip'] ?></b></p>
                <span class="text-black text-medium"><b>NOMOR INDUK PEGAWAI (NIP)</b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control"><b><?= $dosen['nidn'] ?></b></p>
                <span class="text-black text-medium"><b>NOMOR INDUK DOSEN NASIONAL (NIDN)</b></span>
            </label>
        </div>
    </div>

    <!-- Nama Lengkap & Jenis Kelamin -->
    <div class="row g-3">
        <div class="col-md-12">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= $dosen['gelar_depan'] ?> <?= capital(strtolower($dosen['nama'])) ?> <?= $dosen['gelar_blk'] ?>
                </p>
                <span class="text-black"><b>NAMA LENGKAP </b></span>
            </label>
        </div>
    </div>

    <!-- Agama & Kota -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($dosen['nm_agama'])?$dosen['nm_agama']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>AGAMA </b></span>
            </label>
        </div>

        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($dosen['nm_kota'])?$dosen['nm_kota']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>KOTA </b></span>
            </label>
        </div>
    </div>

    <!-- Alamat -->
    <div class="row g-3">
        <div class="col-md-12">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($dosen['alamat'])?$dosen['alamat']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>ALAMAT</b></span>
            </label>
        </div>
    </div>

    <!-- Jabatan, Tanggal Masuk & Menjabat-->
    <div class="row g-3">
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($dosen['nm_jabatan'])?$dosen['nm_jabatan']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>JABATAN </b></span>
            </label>
        </div>

        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($dosen['tgl_masuk'])?date('d-M-Y',strtotime($dosen['tgl_masuk'])):'Belum input'; ?>
                </p>
                <span class="text-black"><b>TANGGAL MASUK </b></span>
            </label>
        </div>

        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($dosen['tmt_jabatan'])?date('d-M-Y',strtotime($dosen['tmt_jabatan'])):'Belum input'; ?>
                </p>
                <span class="text-black"><b>TANGGAL MENJABAT </b></span>
            </label>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($dosen['status'])?$dosen['status']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>STATUS </b></span>
            </label>
        </div>
    </div>


