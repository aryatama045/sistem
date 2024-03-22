	<div class="row">
		<div class="col-12">
			<h1>Report Absensi</h1>
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
					<form action="<?= base_url('leaves/absensi_status/print_action') ?>" method="post" id='form-print'>

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
							<div class="form-group row ">
                                <label class="col-sm-4 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input placeholder="Search by nip" id="nip" name="nip" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-sm-4 col-form-label">NAMA LENGKAP</label>
                                <div class="col-sm-8">
                                    <input placeholder="Search by nama lengkap" id="nama_lengkap" name="nama_lengkap" type="text" class="form-control" >
                                </div>
                            </div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">STATUS ABSENSI</label>
								<div class="col-sm-8">
									<select class="form-control select2 select2-multiple" multiple="multiple" data-width="100%" name="status_absensi[]" id="status_absensi">
										<option value="">--PILIH STATUS ABSENSI--</option>
										<?php foreach($status_absensi as $s) : ?>
											<option value="<?php echo $s->kode_status_absensi ?>"><?php echo $s->ket_status_absensi ?></option>
										<?php endforeach; ?>
									</select>
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
								<select class="form-control" name="nm_departement" id="nm_departement">
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
								</div>
							</div>

						</div>
					</div>
					</form>
				</div>
				<div class="card-body">
					<table id="tableAbsen" class="table table-bordered data-table">
						<thead>
							<tr>
								<th>NIP </th>
								<th>NAMA LENGKAP</th>
								<th>DEPARTEMENT</th>
								<th>TGL. ABSENSI</th>
								<th>JAM MASUK</th>
								<th>JAM KELUAR</th>
								<th>STATUS ABSENSI</th>
								<th>KETERANGAN</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>


<div class="modal fade" id="DetailReport" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="DetailReportLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="data_item"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary"
					data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('report_absensi_status', 'index', 'js');  ?>


