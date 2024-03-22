<style>
	#datepicker {
		width:100px;
		padding:0;
		height:20px;
		line-height:20px;}
	.ui-datepicker {
		/* opacity: 1; */
		position: fixed !important;
		top: 10em !important;
		left: 0;
		z-index: 4;
		/* display: block; */
		}
</style>

<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

			<div id="messages"></div>
			<?php if($this->session->flashdata('success')): ?>
			<div class="alert alert-success " role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo $this->session->flashdata('success'); ?>
			</div>
			<?php elseif($this->session->flashdata('error')): ?>
			<div class="alert alert-danger rounded " role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo $this->session->flashdata('error'); ?>
			</div>
			<?php endif; ?>
			<?php if(validation_errors()): ?>
				<div class="alert alert-danger rounded " role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo validation_errors(); ?>
				</div>
			<?php endif; ?>
				<h5 class="mb-4">PENGAJUAN CUTI DISPENSASI</h5>
				<div class="separator mb-4"></div>
				<form role="form" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<input hidden type="text" name="biodata_id" value="<?= $biodataid ?>" class="form-control"  readonly>

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NO.DOC</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" value="<?= $no_doc ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">TGL. MULAI CUTI</label>
								<div class="col-sm-6">
									<div class="input-group ">
										<span class="input-group-text input-group-append input-group-addon">
											<i class="simple-icon-calendar"></i>
										</span>
										<input  type="date" id="datepicks" class="form-control" name="tgl_mulai_cuti" value="<?= date('Y-m-d');?>" placeholder="Pilih Tanggal" required>
									</div>
								</div>
							</div>
							<div hidden class="form-group row">
								<label class="col-sm-5 col-form-label">TGL.CUTI DOKTER</label>
								<div class="col-sm-6">
									<div class="input-group ">
										<span class="input-group-text input-group-append input-group-addon">
											<i class="simple-icon-calendar"></i>
										</span>
										<input  type="date" id="datepicks2" class="form-control" name="tgl_cuti_dokter" value="<?= date('Y-m-d');?>" placeholder="Pilih Tanggal" required>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JENIS CUTI</label>
								<div class="col-sm-6">
									<?php echo form_dropdown($status_absensi_id, $status_absensi_id_option)?>
								</div>
							</div>
							<div hidden class="form-group row">
								<label class="col-sm-5 col-form-label">SUB CUTI</label>
								<div class="col-sm-6">
								<select class="form-control" id="sub_category" name="jum_cuti" required readonly>
									<option>No Selected</option>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">KETERANGAN</div>
								<div class="col-sm-6">
										<textarea required name="keterangan" placeholder="Silahkan Input Keterangan" class="form-control"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5"></div>
								<div class="col-sm-6">
									<p id="note"></p>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<fieldset class="form-group">
								<div class="row">
									<label class="col-form-label col-sm-5 pt-0">TUNJANGAN</label>
									<div class="col-sm-6" id="biaya">
									</div>
								</div>
							</fieldset>
							<div hidden class="form-group row">
								<label class="col-sm-5 col-form-label">NO.REFF</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="noreff" placeholder="Silahkan Input No Reff">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">TGL.KLAIM</label>
								<div class="col-sm-6">
									<div class="input-group ">
										<span class="input-group-text input-group-append input-group-addon">
											<i class="simple-icon-calendar"></i>
										</span>
										<input type="date" disabled class="form-control" name="tgl_klaim" value="<?= date("Y-m-d") ?>"  placeholder="Pilih Tanggal" required>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">LAMPIRAN 1</div>
								<div class="col-sm-6">
									<input type="file" name="file_1" class="form-control-file" >
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">LAMPIRAN 2</div>
								<div class="col-sm-6">
									<input type="file" name="file_2" class="form-control-file" >
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">LAMPIRAN 3</div>
								<div class="col-sm-6">
									<input type="file" name="file_3" class="form-control-file" >
								</div>
							</div>
						</div>
					</div> <hr>

					<div class="row">
						<div class="form-group row mb-0">
							<div class="col-sm-10">
								<button type="submit" class="btn btn-primary mb-0">Simpan</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('cuti_dispensasi', 'creates', 'js');  ?>
