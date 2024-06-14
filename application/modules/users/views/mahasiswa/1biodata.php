

<h4>Data Diri</h4> <hr class="mb-2">
    <!-- No Daftar & Tanggal -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control"><b><?= $data_mhs['nim'] ?></b></p>
                <span class="text-black text-medium"><b>NOMOR INDUK Mahasiswa (NIM)</b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control"><?= date('d-M-Y',strtotime($data_mhs['tgl_masuk'])) ?></p>
                <span class="text-black text-medium"><b>TANGGAL DAFTAR</b></span>
            </label>
        </div>
    </div>

    <!-- Nama Lengkap & Jenis Kelamin -->
    <div class="row g-3">
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <strong>
                    <?= ($data_mhs['nama_mhs'])?capital(strtolower($data_mhs['nama_mhs'])):'Belum input'; ?>
                    </strong>
                </p>
                <span class="text-black"><b>NAMA LENGKAP </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= $data_mhs['jk'] ?>
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
                    <?= ($data_mhs['tempat_lahir'])?$data_mhs['tempat_lahir']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>TEMPAT LAHIR </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['agama'])?$data_mhs['agama']:'Belum input'; ?>
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
                    <?= ($data_mhs['tgl_lahir'])?date('d-M-Y',strtotime($data_mhs['tgl_lahir'])):'Belum input'; ?>
                </p>
                <span class="text-black"><b>TANGGAL LAHIR </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['ibu_kandung'])?$data_mhs['ibu_kandung']:'Belum input'; ?>
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
                    <b><?= ($data_mhs['nik'])?$data_mhs['nik']:'Belum input'; ?></b>
                </p>
                <span class="text-black"><b>Nomor Induk Kependudukan (NIK) </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['telepon'])?$data_mhs['telepon']:'Belum input'; ?>
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
                    <?= ($data_mhs['nisn'])?$data_mhs['nisn']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>NISN </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['nomor_hp'])?$data_mhs['nomor_hp']:'Belum input'; ?>
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
                    <?= ($data_mhs['npwp'])?$data_mhs['npwp']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>NPWP</b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['email'])?$data_mhs['email']:'Belum input'; ?>
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
                    <?= ($data_mhs['asal_sekolah'])?$data_mhs['asal_sekolah']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>ASAL SMA/SMK</b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['kewarganegaraan'])?$data_mhs['kewarganegaraan']:'Belum input'; ?>
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
                    <?= ($data_mhs['jenis_tinggal'])?$data_mhs['jenis_tinggal']:'Belum input'; ?>
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
                    <?= ($data_mhs['alamat'])?$data_mhs['alamat']:'Belum input'; ?>
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
                    <?= ($data_mhs['kelurahan'])?$data_mhs['kelurahan']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>KELURAHAN </b></span>
            </label>
        </div>
        <div class="col-md-6">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['kecamatan'])?$data_mhs['kecamatan']:'Belum input'; ?>
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
                    <?= ($data_mhs['rt'])?$data_mhs['rt']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>RT</b></span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['rw'])?$data_mhs['rw']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>RW</b></span>
            </label>
        </div>
        <div class="col-md-4">
            <label class="mb-3 top-label">
                <p class="form-control">
                    <?= ($data_mhs['kode_pos'])?$data_mhs['kode_pos']:'Belum input'; ?>
                </p>
                <span class="text-black"><b>KODE POS</b></span>
            </label>
        </div>
    </div>

