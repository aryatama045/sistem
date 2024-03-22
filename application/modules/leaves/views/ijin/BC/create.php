
<?php //$this->load->assets('ijin','create', 'css');  ?>
<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

				<h5 class="mb-4"><i class="iconsminds-mail-3"></i>
				PENGAJUAN IJIN</h5>
				<div class="separator mb-4"></div>

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

				<form role="form" action="<?= base_url('leaves/ijin/create') ?>" method="post"  class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<input hidden type="text" name="biodata_id" value="<?= $biodataid ?>" class="form-control"  readonly>

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NO.DOC</label>
								<div class="col-sm-6">
									<input type="text" name="no_doc" class="form-control" value="<?= $no_doc ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JENIS IJIN</label>
								<div class="col-sm-6">
									<?php echo form_dropdown($status_absensi_id, $status_absensi_id_option)?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">KETERANGAN</div>
								<div class="col-sm-6">
										<textarea name="keterangan" class="form-control"></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group row">
								<div class="col-sm-5">LAMPIRAN 1</div>
								<div class="col-sm-6">
									<input type="file" name="file_1" class="form-control-file">
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
							<div class="form-group row" id="tampil_jam">
								<div class="col-sm-5">JAM HADIR</div>
								<div class="col-sm-6">
									<span id="jam_masuk"> </span>
								</div>
							</div>
						</div>
					</div> <hr>

					<div class="row mb-4"></div>
					<div class="col-12 data-tables-hide-filter">
						<div class="card">
							<div class="card-body">
								<table id="item_table" class="table table-striped table-condensed field_wrapper">
									<thead>
										<tr>
											<th>Tgl & Jam Ijin</th>
											<th>
												<div class="form-check">
													<input class="form-check-input text-center" type="checkbox" id="chkPassport" name="kembali" >
													Kembali
												</div>
											</th>
											<th>Keterangan Ijin</th>
											<th>
														<!-- <button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i> Tambah Ijin</button> -->
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="input-group">
													<span class="input-group-text input-group-append input-group-addon"><i class="simple-icon-calendar"></i></span>	
													<input type='text' class="form-control" id='datetimepicker23' name="tgl_tdk_masuk[]" placeholder="Pilih Tanggal"  />
												</div>
											</td>
											<td>
												<div id="dvPassport" style="display: none">
													<div class="input-group ">
														<input type="datetime-local" class="form-control" value="-" name="tgl_kembali[]" value="<?= date('Y-m-d h:i:s');?>" placeholder="Pilih Tanggal">
													</div>
												</div>
												<div id="AddPassport">
													Kembali
												</div>
											</td>
											<td><input id="keterangan" class="form-control" name="keterangan_cuti[]" placeholder="Keterangan" type="text" /></td>
											<td>
													<div id="jam_hadir">
														<button id="addnew" type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i> Tambah Ijin</button>
													</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<hr>

					<div class="row">
						<div class="form-group row mb-0">
							<div class="col-sm-10">
								<button type="submit" class="btn btn-lg btn-primary mb-0">Simpan</button>
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
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('ijin', 'create', 'js');  ?>

