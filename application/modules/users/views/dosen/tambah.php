
<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>

<div class="row">
	<div class="col">

		<!-- Title and Top Buttons Start -->
		<div class="page-title-container">
			<div class="row">

				<!-- Title Start -->
				<div class="col-12 col-md-7">

					<h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?></h1>

					<?php $this->load->view('templates/breadcrumb'); ?>

				</div>
				<!-- Title End -->

                <!-- Top Buttons Start -->
                <div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
                    <!-- Add New Button Start -->
                    <a href="<?= base_url($mod.'/'.$func) ?>" class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto add-datatable">
                        <i data-acorn-icon="arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <!-- Add New Button End -->
                </div>
                <!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->

        <?php $this->load->view('templates/notif') ?>

        <!-- Content Start -->
		<div class="card">
			<div class="card-body">
                <h3 class="pb-0">Form  <?= $function ?> - <?= $pagetitle ?></h3>
                <hr class="mb-2">

                <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">
                    <div class="col-12 col-md-6" >
                        <label class="form-label text-black"><strong>Nomor Induk Pegawai (NIP) <span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="nip" placeholder="Input Nomor Induk Pegawai"/>
                    </div>
                    <div class="col-12 col-md-6" >
                        <label class="form-label text-black"><strong>Nomor Induk Dosen Nasional (NIDN) <span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="nidn" placeholder="Input Nomor Induk Dosen Nasional"/>
                    </div>

                    <div class="col-12 col-md-12">
                        <label class="form-label text-black"><strong>Nama Lengkap Dosen<span style="color:red">*</span> dan Gelar </strong></label>
                        <div class="input-group">
                            <input type="text" name="gelar_depan"  class="form-control" placeholder="Gelar Depan">
                            <input type="text" required name="nama" class="form-control" placeholder="Nama Lengkap">
                            <input type="text" required name="gelar_blk" class="form-control" placeholder="Gelar Belakang">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-black"><strong>Agama<span style="color:red">*</span></strong></label>
                        <select class="form-control" name="agama" required>
                            <option value="" >-- Select Agama --</option>
                            <?php foreach($agama as $key => $val) { ?>
                            <option value="<?= $val['id'] ?>"> <?= $val['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-black"><strong>Kota<span style="color:red">*</span></strong></label>
                        <select class="form-control" name="kota" required>
                            <option value="" >-- Select Kota --</option>
                            <?php foreach($kota as $key => $val) { ?>
                            <option value="<?= $val['id'] ?>"> <?= $val['nm_kota'] ?></option>
                            <?php } ?>
                        </select>
                    </div>


                    <div class="col-12 col-md-12 mb-5">
                        <label class="form-label text-black"><strong> Alamat</strong></label>
                        <textarea name="alamat" row="3" class="form-control" placeholder="Input Alamat"></textarea>
                    </div>

                    <h4 class="pb-0"> Data Akademik</h4>
                    <hr class="mb-1">

                    <div class="col-12 col-md-3">
                        <label class="form-label text-black"><strong>Jabatan<span style="color:red">*</span></strong></label>
                        <select class="form-control" name="jabatan" required>
                            <option value="" >-- Select Jabatan --</option>
                            <?php foreach($jabatan as $key => $val) { ?>
                            <option value="<?= $val['id'] ?>"> <?= $val['nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label text-black"><strong>Status<span style="color:red">*</span></strong></label>
                        <select class="form-control" name="status" required>
                            <option value="<?= $dosen['status'] ?>" >-- Status  <?= $dosen['status'] ?>--</option>

                            <option value="T"> Tetap</option>
                            <option value="P"> PKWT</option>
                            <option value="H"> Honorer</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3" >
                        <label class="form-label text-black"><strong>Tanggal Masuk<span style="color:red">*</span></strong></label>
                        <input class="form-control" name="tgl_masuk" required id="selectTanggalAwal" />
                    </div>

                    <div class="col-12 col-md-3" >
                        <label class="form-label text-black"><strong>Tanggal Menjabat<span style="color:red">*</span></strong></label>
                        <input class="form-control" name="tmt_jabatan" required id="selectTanggalAkhir" />
                    </div>

                    <hr>
                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-primary"><i data-acorn-icon="save"></i> Simpan</button>
                    </div>

                    <div class="col-12 mt-2">
                        <label class="form-check-label" ><strong> Note : </strong><span style="color:red">*</span> Wajib</label>
                    </div>
                </form>
            </div>
        </div>
        <!-- Content End -->
    </div>
</div>

