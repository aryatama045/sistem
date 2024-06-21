
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
                        <label class="form-label text-black"><strong>Nomor Induk Mahasiswa (NIM) <span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="nim" placeholder="Input Nomor Induk Mahasiswa"/>
                    </div>
                    <div class="col-12 col-md-6" >
                        <label class="form-label text-black"><strong>Nomor Induk Kependudukan (NIK) <span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="nik" placeholder="Input Nomor Induk Kependudukan"/>
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label text-black"><strong>Nama Mahasiswa<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="nama_mhs" placeholder="Input Nama Mahasiswa" />
                    </div>

                    <div class="col-12 col-md-6" >
                        <label class="form-label text-black"><strong>Tempat Lahir <span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="tempat_lahir" placeholder="Input Tempat Lahir"/>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label text-black"><strong>Jenis Kelamin<span style="color:red">*</span></strong></label>
                        <select class="form-control" name="jenis_kelamin" required>
                            <option value=""> -- Select Jenis Kelamin --</option>
                            <option value="L"> LAKI-LAKI</option>
                            <option value="P"> PEREMPUAN</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6" >
                        <label class="form-label text-black"><strong>Tanggal Lahir <span style="color:red">*</span></strong></label>
                        <input class="form-control" type="text" name="tgl_lahir" required id="selectTanggal" placeholder="Input Tanggal Lahir"/>
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

                    <div class="col-12 col-md-12 mb-5">
                        <label class="form-label text-black"><strong> Alamat</strong></label>
                        <textarea name="alamat"  row="3" class="form-control" placeholder="Input Alamat"></textarea>
                    </div>

                    <h4 class="pb-0"> Data Akademik</h4>
                    <hr class="mb-1">

                    <div class="col-12 col-md-3 ">
                        <label class="form-label text-black"><strong> Program Studi<span style="color:red">*</span></strong></label>
                        <select name="kd_prog" required class="form-select">
                            <option value="">-- Select Program Studi --</option>
                            <?php foreach($prodi as $val) { ?>
                                <option value="<?= $val['kd_prog'] ?>"> <?= $val['nama_prog'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-3 ">
                        <label class="form-label text-black"><strong> Semester<span style="color:red">*</span></strong></label>
                        <select name="smt" required class="form-select">
                            <option value="">-- Select Semester --</option>
                            <option value="1"> Semester 1</option>
                            <option value="2"> Semester 2</option>
                            <option value="3"> Semester 3</option>
                            <option value="4"> Semester 4</option>
                            <option value="5"> Semester 5</option>
                            <option value="6"> Semester 6</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-3 ">
                        <label class="form-label text-black"><strong> Tahun Ajaran<span style="color:red">*</span></strong></label>
                        <select name="kd_ta" required class="form-select">
                            <option value="">-- Select Tahun Ajaran --</option>
                            <?php foreach($ta as $key => $val) { ?>
                                <option value="<?= $val['kd_ta'] ?>"> <?= $val['ta'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-3 ">
                        <label class="form-label text-black"><strong>  Biaya<span style="color:red">*</span></strong></label>
                        <select name="kd_biaya" required class="form-select">
                            <option value="">-- Select Biaya --</option>
                            <?php foreach($biaya as $key => $val) { ?>
                                <option value="<?= $val['kd_biaya'] ?>"> <?= nominal($val['nilai']) ?></option>
                            <?php } ?>
                        </select>
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

