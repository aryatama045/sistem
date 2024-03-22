<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

			<div id="messages"></div>

				<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php elseif($this->session->flashdata('error')): ?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php endif; ?>
				<?php if(validation_errors()): ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>
				<h5 class="mb-4">Detail Cuti Pengganti</h5>
				<div class="separator mb-4"></div>
				<form role="form" action="<?php base_url('leaves/cuti_tambahan/approve_action') ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NO.DOC</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="no_doc" value="<?= $header_data['header']['no_dok_tdk_masuk'] ?>" readonly>
									<input type="text" hidden class="form-control" name="biodata_id" value="<?= $header_data['header']['biodata_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="tdk_masuk_h_id" value="<?= $header_data['header']['tdk_masuk_h_id'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-5 col-form-label">SUMBER POTONG CUTI</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="potong_cuti_dari" value="<?= $header_data['header']['potong_cuti_dari'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">STATUS CUTI</label>
								<div class="col-sm-7">
								<input type="text" class="form-control" name="status_cuti" value="<?= $header_data['header']['ket_status_absensi'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">KETERANGAN</div>
								<div class="col-sm-7">
										<textarea name="keterangan" readonly name="keterangan_header" class="form-control"><?= $header_data['header']['keterangan'] ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<fieldset class="form-group">
								<div class="row">
									<label class="col-form-label col-sm-5 pt-0">NORMATIF</label>
									<div class="col-sm-4">
										<label class="form-check-label">
										<?= $header_data['header']['sisa_saldo_normatif'] ?>
										<?php if($header_data['header']['sisa_saldo_normatif'] ==0 && $header_data['header']['sisa_saldo_normatif'] =='' ) { ?>
											<input type="text" hidden name="sisa_normatif" value="<?php echo $header_data['header']['sisa_saldo_normatif'] ?>">
											<input type="text" hidden name="mulai_berlaku_normatif" value="<?php echo $header_data['header']['mulai_berlaku_normatif'] ?>">
											<input type="text" hidden name="akhir_berlaku_normatif"  value="<?php echo $header_data['header']['akhir_berlaku_normatif'] ?>">
										<?php } ?>
										</label>
									</div>
								</div>
								<div class="row">
									<label class="col-form-label col-sm-5 pt-0">BONUS</label>
									<div class="col-sm-4">
										<label class="form-check-label">
										<?= $header_data['header']['sisa_saldo_bonus'] ?>
										<?php if($header_data['header']['sisa_saldo_bonus'] ==0 && $header_data['header']['sisa_saldo_bonus'] =='' ) { ?>
											<input type="text" hidden name="sisa_bonus" value="<?php echo $header_data['header']['sisa_saldo_bonus'] ?>">
											<input type="text" hidden name="mulai_berlaku_bonus" value="<?php echo $header_data['header']['mulai_berlaku_bonus'] ?>">
											<input type="text" hidden name="akhir_berlaku_bonus"  value="<?php echo $header_data['header']['akhir_berlaku_bonus'] ?>">
										<?php } ?>
										</label>
									</div>
								</div>
								<div class="row">
									<label class="col-form-label col-sm-5 pt-0">TAMBAHAN</label>
									<div class="col-sm-4">
										<label class="form-check-label">
											<?= $header_data['header']['sisa_saldo_tambahan'] ?>
											<?php if($header_data['header']['sisa_saldo_tambahan'] ==0 && $header_data['header']['sisa_saldo_tambahan'] =='' ) { ?>
												<input type="text" hidden name="sisa_tambahan" value="<?php echo $header_data['header']['sisa_saldo_tambahan'] ?>">
												<input type="text" hidden name="mulai_berlaku_tambahan" value="<?php echo $header_data['header']['mulai_berlaku_tambahan'] ?>">
												<input type="text" hidden name="akhir_berlaku_tambahan"  value="<?php echo $header_data['header']['akhir_berlaku_tambahan'] ?>">
											<?php } ?>
										</label>
									</div>
								</div>
								<div class="row">
									<label class="col-form-label col-sm-5 pt-0">JML AMBIL</label>
									<div class="col-sm-4">
										<label class="form-check-label">
											<?= $header_data['header']['jml_ambil'] ?>
											<input type="text" hidden name="jml_ambil" value="<?php echo $header_data['header']['jml_ambil'] ?>">
										</label>
									</div>
								</div>
							</fieldset>
						</div>
						<div class="col-lg-2">
							<div class="form-group row">
								<div class="col-sm-9">SUDAH POSTING</div>
								<div class="col-sm-2">
									<div class="form-check">
										<?php if($header_data['header']['is_posting']!='0') {  $checked='checked';  } else{$checked='';} ?>
										<input readonly class="form-check-input" type="checkbox" id="gridCheck1" <?= $checked ?> disabled>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-9">BATAL</div>
								<div class="col-sm-2">
									<div class="form-check">
									<?php if($header_data['header']['is_batal']!='0') {  $checkeds='checked';  } else{$checkeds='';} ?>
										<input readonly class="form-check-input" type="checkbox" id="gridCheck2" <?= $checkeds ?> disabled>
									</div>
								</div>
							</div>
						</div>
					</div> <hr>

					<div class="row mb-4">
						<div class="col-12 data-tables-hide-filter">
							<div class="card">
								<div class="card-body">
									<table id="TableCuti" class="table table-striped table-condensed">
										<thead>
											<tr><th>Tgl Cuti</th>
												<th>Keterangan Cuti</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										<?php if(isset($header_data['detail_item'])):?>
											<?php foreach ($header_data['detail_item'] as $key => $val) : ?>
											<tr>
												<td>
													<div class="input-group ">
														<span class="input-group-text input-group-append input-group-addon ">
															<i class="simple-icon-calendar"></i>
														</span>
														<input type="text" class="form-control " name="tgl_tdk_masuk[]" value="<?= $val['tgl_tdk_masuk'] ?>" readonly>
													</div>
												</td>
												<td><input id="keterangan" class="form-control" readonly name="keterangan_cuti[]" value="<?= $val['keterangan'] ?>" type="text" /></td>
											</tr>
											<?php endforeach;?>
											<?php endif; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="form-group row mb-0">
							<div class="col-sm-5">
								<button onclick="history.go(-1); return false;" class="btn btn-primary mb-0"> Kembali</button>
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

<?php echo $this->load->assets('create', $js, 'js');  ?>

