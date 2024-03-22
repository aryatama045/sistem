<style>
	#datepicker {
		width:100px; 
		padding:0;
		height:20px;
		line-height:20px;}
	.ui-datepicker {
		opacity: 1;
		position: fixed !important;
		top: 460px !important;
		left: 465px !important;
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

							<h5 class="mb-4">PENGAJUAN CUTI PENGGANTI</h5>
							<div class="separator mb-4"></div>
							<form role="form" action="<?php base_url('cuti_pengganti/create') ?>" method="post" class="form-horizontal">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group row">
										<label class="col-sm-5 col-form-label">NO DOKUMEN</label>
										<div class="col-sm-6">
											<input type="text" id="no_doc" name="no_doc" class="form-control" value="<?= $no_docs ?>" readonly>
										</div>
									</div>
									<div class="form-group row"> 
										<label class="col-sm-5 col-form-label">TGL DOKUMEN </label>
										<div class="col-sm-6">
											<input type="date" id="tgl_doc" name="tgl_doc" class="form-control" readonly value="<?= date('Y-m-d');?>" placeholder="Pilih Tanggal Awal Berlaku">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-form-label">N.I.P</label>
										<div class="col-sm-6">
											<input type="text" id="nip" name="nip" class="form-control" value="<?= $this->session->userdata('nama_login'); ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-form-label">NAMA KARYAWAN</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" value="<?= $this->session->userdata('nama_karyawan'); ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-form-label">TANGGAL MASUK</label>
										<div class="col-sm-6" type="text">
											<input type="text" id="tgl_awal" name="tgl_awal" class="form-control" value="<?= date('Y-m-d');?>" placeholder="Pilih Tanggal Masuk">
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group row">
										<label class="col-sm-5 col-form-label">JAM MASUK : </label>
										<div class="col-sm-6">
											<div id="jam1"></div>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-form-label">JAM KELUAR : </label>
										<div class="col-sm-6">
											<div id="jam2"></div>
										</div>
									</div>



									<div class="form-group row">
										<label class="col-sm-5 col-form-label">JUMLAH HARI</label>
										<div class="col-sm-6" >
											<select class="form-control select2-single" data-width="100%" id="jml_hari" name="jml_hari">
												<option value=""></option>
												<option value="0.5">0.5 hari</option>
												<option value="1.0">1 hari</option>
												<option value="1.5">1.5 hari</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-5 col-form-label">KETERANGAN</label>
										<div class="col-sm-6">
											<textarea id="keterangan" name="keterangan" class="form-control"></textarea>
										</div>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="form-group row mb-0">
									<div class="col-sm-10">
										<button type="submit" class="btn btn-primary mb-0">Simpan</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('cuti_tambahan', 'create', 'js');?>
