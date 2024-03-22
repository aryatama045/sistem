<style>
	td.details-control {
		background: url('../../theme/assets/details_open.png') no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url('../../theme/assets/details_close.png') no-repeat center center;
	}

	.btn-toolbar.sw-toolbar.sw-toolbar-bottom.justify-content-end {
		display: none;
	}

	.dataTables_scrollHeadInner{
			width: 100% !important;
	}

	.select2-container--default .select2-selection--single .select2-selection__clear {
		cursor: pointer;
		float: left;
		font-weight: bold;
		margin-left: 11px;
		padding-right: 10px;
	}
</style>

<link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/vendor/bootstrap-float-label.min.css" />


<div class="row">
		<div class="col-12">
			<h1>Report Cuti Pengganti</h1>
			<div class="top-right-button-container">
			</div>
			<div class="separator"></div>
			<br>
		</div>
	</div>

	<!-- <div id="messages"></div> -->

	<div class="row">
		<div class="col-12 ">
			<div class="card">
				<div class="card-body">
				<form action="print_action" method="post" id='form-print'>
					<div class="row">
						<div class="col-md-7">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">TANGGAL</label>
								<div class="col-sm-8">
									<input type="hidden" name="action" id="action" />
									<div class="input-group">
									<input class="input-sm form-control" type="date" name="tanggal1" id="tanggal1" value="<?php echo date("Y") . "-" . date("m") . "-" . "01"; ?>" placeholder="FROM DATE" required>
									<span class="input-group-addon"></span>
									<input class="input-sm form-control" type="date" name="tanggal2" id="tanggal2" value="<?php echo date("Y-m-t", strtotime(date("Y-m-t"))); ?>" placeholder="TO DATE" required>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label">KARYAWAN</label>
								<div class="col-sm-8">
									<label class="has-float-label">
									<select class=" form-control select2-single" width="100%" name="karyawan" id="karyawan">
										<option value="" selected></option>
										<?php foreach($data_karyawan as $d) {
											if(!empty($d->nama_lengkap)){ ?>

												<option value="<?= $d->nip ?>"><?= $d->nip ?> - <?= $d->nama_lengkap ?></option>

										<?php } } ?>
									</select>
									<span>Select Karyawan</span>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA DIVISI</label>
								<div class="col-sm-8">
									<select class="form-control" name="nm_divisi" id="nm_divisi">
										<option value="">--PILIH DIVISI--</option>
										<?php foreach($nm_divisi as $d) : ?>
										<option value="<?php echo $d->divisi_id ?>"><?php echo $d->nama_divisi ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA DEPARTEMENT</label>
								<div class="col-sm-8">
								<select class="form-control " name="nm_departement" id="nm_departement">
									<option value="">--PILIH SEMUA DEPARTMENT--</option>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA STORE</label>
								<div class="col-sm-8">
								<select class="form-control select2-single" name="nm_store" id="nm_store">
									<option value="">--PILIH SEMUA STORE--</option>
								</select>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-sm-4"></div>
								<div class="col-sm-8 align-self-end">
									<button type="button" class="btn btn-outline-primary" id='btn-pdf-action' title="Print PDF">P D F</button>
									<button type="button" class="btn btn-outline-primary" id='btn-excel-action' title="Export Excel">EXCEL</button>
									<!-- <button type="button" id="btn-tampil" class="btn btn-outline-primary">Tampilkan</button> -->
								</div>
							</div>

						</div>
					</div>
				</form>
				</div>
				<div class="card-body">
					<table id="dataTable" class="table table-bordered data-table">
						<thead>
							<tr>
								<th>Detail</th>
                                <th>NO.DOC</th>
								<th>NIP </th>
								<th>NAMA LENGKAP</th>
								<th>TGL AWAL</th>
								<th>TGL AKHIR</th>
                                <th>STORE</th>
								<th>DEPARTEMENT </th>
								<th>KET.</th>
								<th>STATUS</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>





<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('report/cuti_pengganti', 'index', 'js');?>



