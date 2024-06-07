
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
                <h3 class="pb-0">Form <?= $function ?> - <?= $pagetitle ?></h3>
                <hr class="mb-2">

                <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">
                    <div class="col-12 col-md-6">
                        <label class="form-label text-black-50"><strong>Periode Daftar<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="gel" placeholder="Input Periode Daftar" />
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-black-50"><strong> Tahun Ajaran<span style="color:red">*</span></strong></label>
                        <select name="kd_ta" required class="form-select">
                            <option value="">-- Select Tahun Ajaran --</option>
                            <?php foreach($ta as $key => $val) { ?>
                                <option value="<?= $val['kd_ta'] ?>">(<?= $val['kd_ta'] ?>) <?= $val['ta'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6" >
                        <label class="form-label text-black"><strong>Tanggal Awal <span style="color:red">*</span></strong></label>
                        <input class="form-control" name="tgl_awal" required id="selectTanggalAwal" value="<?= date('d/m/Y') ?>" />
                    </div>

                    <div class="col-12 col-md-6" >
                        <label class="form-label text-black"><strong>Tanggal Akhir <span style="color:red">*</span></strong></label>
                        <input class="form-control" name="tgl_akhir" required id="selectTanggalAkhir" value="<?= date('d/m/Y') ?>" />
                    </div>

                    <div class="col-12">
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