
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
                <h3 class="pb-0">Form Tambah - <?= $pagetitle ?></h3>
                <hr class="mb-2">

                <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">
                    <div class="col-12 col-md-4">
                        <label class="form-label"><strong>Kode Mata Kuliah<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="kode_matkul" placeholder="Input Kode Mata Kuliah" />
                    </div>
                    <div class="col-12 col-md-8">
                        <label class="form-label"><strong>Nama Mata Kuliah<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="nama_matkul" placeholder="Input Nama Mata Kuliah" />
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><strong>Jumlah SKS<span style="color:red">*</span></strong></label>
                        <input type="text" class="form-control" required name="sks" placeholder="Input Jumlah SKS" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong> Kode Program<span style="color:red">*</span></strong></label>
                        <select name="kd_prog" required class="form-select">
                            <option value="">-- Select Kode Program --</option>
                            <?php foreach($prodi as $key => $val){ ?>
                                <option value="<?= $val['kd_prog'] ?>">(<?= $val['kd_prog'] ?>) <?= $val['nama_prog'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong> Semester<span style="color:red">*</span></strong></label>
                        <select name="smt" required class="form-select">
                            <option value="">-- Select Semester --</option>
                            <option value="1"> Semester 1</option>
                            <option value="2"> Semester 2</option>
                            <option value="3"> Semester 3</option>
                            <option value="4"> Semester 4</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" name="aktif" type="checkbox" id="gridCheck" required value="1" />
                            <label class="form-check-label" > Status Aktif<span style="color:red">*</span></label>
                        </div>
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