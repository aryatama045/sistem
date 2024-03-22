<style>
	#datepicker {
		width:100px; 
		padding:0;
		height:20px;
		line-height:20px;}
	.ui-datepicker {
		/* opacity: 1; */
		/* position: absolute; */
		top: 460px !important;
		left: 380px !important;
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
				<h5 class="mb-4">PENGAJUAN CUTI</h5>
				<div class="separator mb-4"></div>
				<form role="form" action="<?php base_url('cuti_normal/create') ?>" method="post" class="form-horizontal">
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
								<label class="col-sm-5 col-form-label">SUMBER POTONG CUTI</label>
								<div class="col-sm-6">
									<select class="form-control select2-single"  name="potong_cuti_dari" data-width="100%">

											<option value="NORMATIF">NORMATIF</option>
											<option value="TAMBAHAN">TAMBAHAN</option>

									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JENIS CUTI</label>
								<div class="col-sm-6">
									<?php //echo form_dropdown($status_absensi_id, $status_absensi_id_option)?>
									<select name="jumlah_hari"  class="form-control select2-single" required>
										<option value="">-- Pilih Jenis Cuti --</option>
										<option value="0.5">CUTI 1/2 HARI</option>
										<option value="1">CUTI 1 HARI</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">KETERANGAN</div>
								<div class="col-sm-6">
										<textarea name="keterangan" class="form-control" ></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<fieldset class="form-group">
								<div class="row">
									<label class="col-form-label col-sm-7 pt-0">NORMATIF ( <?= date('Y') ?> )</label>
									<div class="col-sm-4">
										<label class="form-check-label">
											<?php echo $normatifs['sisa_normatif'] ?>
											<input type="text" hidden name="sisa_normatif" value="<?php echo $normatifs['sisa_normatif'] ?>">
											<input type="text" hidden name="mulai_berlaku_normatif" value="<?php echo $normatifs['tgl_mulai_berlaku'] ?>">
											<input type="text" hidden name="akhir_berlaku_normatif"  value="<?php echo $normatifs['tgl_akhir_berlaku'] ?>">
										</label>
									</div>
								</div>

								<?php if($normatifsny) { ?>
								<div class="row">
									<label class="col-form-label col-sm-7 pt-0">NORMATIF ( <?= date('Y')+1 ?> )</label>
									<div class="col-sm-4">
										<label class="form-check-label">
											<?php echo $normatifsny['sisa_normatif'] ?>
											<input type="text" hidden name="sisa_normatif" value="<?php echo $normatifsny['sisa_normatif'] ?>">
											<input type="text" hidden name="mulai_berlaku_normatif" value="<?php echo $normatifsny['tgl_mulai_berlaku'] ?>">
											<input type="text" hidden name="akhir_berlaku_normatif"  value="<?php echo $normatifsny['tgl_akhir_berlaku'] ?>">
										</label>
									</div>
								</div>
								<?php } ?>


								<div hidden class="row">
									<label class="col-form-label col-sm-7 pt-0">BONUS</label>
									<div class="col-sm-4">
										<label class="form-check-label">
										<?php if($bonus['sisa_cuti']=='' || $bonus['sisa_cuti']=='0') { ?>
												0
												<input type="text" name="sisa_bonus" hidden value="0" />
											<?php } else {?>
												<?php echo $bonus['sisa_cuti'] ?>
												<input type="text" hidden name="sisa_bonus" value="<?php echo $bonus['sisa_cuti'] ?>">
												<input type="text" hidden name="urut_bonus" value="<?php echo $bonus['urut_bonus'] ?>">
											<?php } ?>
											<input type="text" hidden name="mulai_berlaku_bonus" value="<?php echo $bonus['tgl_mulai_berlaku'] ?>">
											<input type="text" hidden name="akhir_berlaku_bonus"  value="<?php echo $bonus['tgl_akhir_berlaku'] ?>">
										</label>
									</div>
								</div>
								<div class="row">
									<label class="col-form-label col-sm-7 pt-0">TAMBAHAN</label>
									<div class="col-sm-4">
										<label class="form-check-label">
										<?php if($tambahan['sisa_cuti_tambahan']=='' || $tambahan['sisa_cuti_tambahan']=='0') { ?>
												0
												<input type="text" name="sisa_tambahan" hidden value="0" />
											<?php } else {?>
												<?php echo $tambahan['sisa_cuti_tambahan'] ?>
												<input type="text" hidden name="sisa_tambahan" value="<?php echo $tambahan['sisa_cuti_tambahan'] ?>">
												<input type="text" hidden name="mulai_berlaku_tambahan" value="<?php echo $masa_ASC['tgl_mulai_berlaku'] ?>">
												<input type="text" hidden name="akhir_berlaku_tambahan"  value="<?php echo $masa_DESC['tgl_akhir_berlaku'] ?>">
											<?php } ?>
										</label>
									</div>
								</div>
								<div class="row">
									<label class="col-form-label col-sm-7 pt-0">JML AMBIL</label>
									<div class="col-sm-4 pt-0">
										<label class="form-check-label">
										</label>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="col-lg-3">
							<?php if($masa_tambahan != null) { ?>
							<div class="form-group">
								<label class="form-check-label text-center">MASA BERLAKU CUTI TAMBAHAN</label>
								<div class="separator mb-2"></div>
								<?php foreach($masa_tambahan as $value){ ?>
									<?php echo $value['tgl_mulai_berlaku'] ?>
									Sampai
									<?php echo $value['tgl_akhir_berlaku'] ?><br>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div> <hr>

					<div class="row mb-4">
						<div class="col-12 data-tables-hide-filter">
							<div class="card">
								<div class="card-body">
									<table id="item_table" class="table table-striped table-condensed field_wrapper">
										<thead>
											<tr><th>Tgl Cuti</th>
												<!-- <th>Keterangan Cuti</th> -->
												<th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i> Tambah Cuti</button></th>
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
											</tr>
										</tbody>
									</table>
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
				</form>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('cuti', 'creates', 'js');  ?>
