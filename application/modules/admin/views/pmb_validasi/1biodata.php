

    <h4>Data Diri</h4> <hr class="mb-2">
    <!-- No Daftar & Tanggal -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control"><b><?= $pmb_validasi['no_pendaftaran'] ?></b></p>
                <span class="text-black text-medium"><b>NOMOR DAFTAR</b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control"><?= date('d-M-Y',strtotime($pmb_validasi['tgl_input'])) ?></p>
                <span class="text-black text-medium"><b>TANGGAL DAFTAR</b></span>
            </label>
        </div>
    </div>

    <!-- Nama Lengkap & Jenis Kelamin -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['nama'])?$pmb_validasi['nama']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>NAMA LENGKAP </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['jenis_kelamin']=='L')?'Laki-Laki':'Perempuan'; ?>
                </p>
                <span class="text-black"><b>JENIS KELAMIN </b></span>
            </label>
        </div>
    </div>

    <!-- Tempat Lahir & Agama -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['tempat_lahir'])?$pmb_validasi['tempat_lahir']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>TEMPAT LAHIR </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['agama'])?$pmb_validasi['agama']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>AGAMA </b></span>
            </label>
        </div>
    </div>

    <!-- Tanggal Lahir & Ibu Kandung -->
    <div class="row g-3 mb-5">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['tanggal_lahir'])?date('d-M-Y',strtotime($pmb_validasi['tanggal_lahir'])):'Belum input'; ?>
                </p>
                <span class="text-black"><b>TANGGAL LAHIR </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['ibu_kandung'])?$pmb_validasi['ibu_kandung']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>NAMA IBU KANDUNG </b></span>
            </label>
        </div>
    </div>

    <h5>Data Lainnya</h5> <hr class="mb-2">
    <!-- NIK & Telepon -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['nik'])?$pmb_validasi['nik']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>Nomor Induk Kependudukan (NIK) </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['telepon'])?$pmb_validasi['telepon']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>TELEPON</b></span>
            </label>
        </div>
    </div>

    <!-- NISN & No Hp -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['nisn'])?$pmb_validasi['nisn']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>NISN </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['nomor_hp'])?$pmb_validasi['nomor_hp']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>NOMOR HP.</b></span>
            </label>
        </div>
    </div>

    <!-- NPWP & Email -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['npwp'])?$pmb_validasi['npwp']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>NPWP</b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['email'])?$pmb_validasi['email']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>E-MAIL </b></span>

            </label>
        </div>
    </div>

    <!-- Asal SMA/SMK & Kewarganegaraan -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['asal_sekolah'])?$pmb_validasi['asal_sekolah']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>ASAL SMA/SMK</b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['kewarganegaraan'])?$pmb_validasi['kewarganegaraan']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>KEWARGANEGARAAN</b></span>
            </label>
        </div>

    </div>

    <!-- Jenis Tinggal -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['jenis_tinggal'])?$pmb_validasi['jenis_tinggal']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>JENIS TINGGAL</b></span>
            </label>
        </div>
    </div>

    <!-- Tempat Tinggal -->
    <div class="row g-3">
        <div class="col-md-12">
            <label class="mb-3 top-label">
            <p class="form-control">
                    <?= ($pmb_validasi['alamat'])?$pmb_validasi['alamat']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>ALAMAT</b></span>
            </label>
        </div>
    </div>

    <!-- Jenis Tinggal -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['kelurahan'])?$pmb_validasi['kelurahan']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>KELURAHAN </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['kecamatan'])?$pmb_validasi['kecamatan']:'Belum input'; ?>
                </p>
                <span class="text-black"><b> KECAMATAN </b></span>
            </label>
        </div>
    </div>

    <!-- Rt-Rw-Kode Pos -->
    <div class="row g-3">
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['rt'])?$pmb_validasi['rt']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>RT</b></span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['rw'])?$pmb_validasi['rw']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>RW</b></span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($pmb_validasi['kode_pos'])?$pmb_validasi['kode_pos']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>KODE POS</b></span>
            </label>
        </div>
    </div>

