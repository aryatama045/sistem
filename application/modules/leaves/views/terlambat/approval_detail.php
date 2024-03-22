

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
				<h5 class="mb-4">Detail Ijin</h5>
				<div class="separator mb-4"></div>
				<form role="form" action="" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NO.DOC</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="no_doc" value="<?= $header_data['header']['no_dok_tdk_masuk'] ?>" readonly>
									<input type="text" hidden class="form-control" name="biodata_id" value="<?= $header_data['header']['biodata_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="tdk_masuk_h_id" value="<?= $header_data['header']['tdk_masuk_h_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="tgl_cuti" value="<?= $header_data['header']['tgl_dok_tdk_masuk'] ?>" readonly>

									<input type="text" hidden class="form-control" name="kode_store" value="<?= $kodestore['kd_store'] ?>" readonly>
									<input type="text" hidden class="form-control" name="gol_absensi_h_id" value="<?= $golabsen['gol_absensi_h_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="kode_gol_absensi" value="<?= $golabsen['kode_gol_absensi'] ?>" readonly>
									<input type="text" hidden class="form-control" name="gol_absensi_d_id" value="<?= $golabsen['gol_absensi_d_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="hari" value="<?= $golabsen['hari'] ?>" readonly>
									<input type="text" hidden class="form-control" name="jam_masuk" value="<?= $golabsen['jam_masuk'] ?>" readonly>
									<input type="text" hidden class="form-control" name="jam_keluar" value="<?= $golabsen['jam_keluar'] ?>" readonly>
								</div>
							</div>
							<div  class="form-group row">
								<label class="col-sm-5 col-form-label">STATUS CUTI</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="status_cuti" value="<?= $header_data['header']['ket_status_absensi'] ?>" readonly>
									<input type="text" class="form-control" hidden name="status_absensi_id" value="<?= $header_data['header']['status_absensi_id'] ?>" readonly>
									<input type="text" class="form-control" hidden name="status" value="<?= $header_data['header']['kode_status_absensi'] ?>" readonly>
									<input type="text" class="form-control" hidden name="kode_status_absensi" value="<?= $header_data['header']['kode_status_absensi'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">KETERANGAN</div>
								<div class="col-sm-6">
										<textarea name="keterangan" readonly name="keterangan_header" class="form-control"><?= $header_data['header']['keterangan'] ?></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-5">
							<div class="form-group row">
								<div class="col-sm-3">Lampiran 1</div>
								<div class="col-sm-6">
									<a class="test-popup-link"
										href="<?php echo base_url('upload/ijin/'.$header_data['header']['file_1']) ?>">
										<img src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_1']) ?>" 
										width="90px">
									</a>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3">Lampiran 2</div>
								<div class="col-sm-6">
									<a class="test-popup-link"
										href="<?php echo base_url('upload/ijin/'.$header_data['header']['file_2']) ?>">
										<img src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_2']) ?>" 
										width="90px">
									</a>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-3">Lampiran 3</div>
								<div class="col-sm-6">
									<a class="test-popup-link"
										href="<?php echo base_url('upload/ijin/'.$header_data['header']['file_3']) ?>">
										<img src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_3']) ?>" 
										width="90px">
									</a>
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
											<tr><th>Tgl & Jam Ijin</th>
												<th>Keterangan Ijin</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
										<?php
											$sisa_normatif = $this->input->post('sisa_normatif');
											$sisa_bonus = $this->input->post('sisa_bonus');
											$sisa_tambahan = $this->input->post('sisa_tambahan'); 
											$jml_awal = $sisa_normatif + $sisa_bonus + $sisa_tambahan;?>
										<?php if(isset($header_data['detail_item'])):?>
											<?php  foreach ($header_data['detail_item'] as $key => $val)  :  ?>
											<tr>
												<td>
													<div class="input-group ">
														<span class="input-group-text input-group-append input-group-addon ">
															<i class="simple-icon-calendar"></i>
														</span>
														<input type="text" class="form-control " value="<?= $val['tgl_tdk_masuk'] ?> | <?= $val['jam_ijin'] ?>" readonly>
														<input type="text" class="form-control " hidden name="tgl_tdk_masuk[]" value="<?= $val['tgl_tdk_masuk'] ?>" readonly>
														<input type="text" class="form-control " hidden name="jam_ijin[]" value="<?= $val['jam_ijin'] ?>" readonly>
														<input type="text" class="form-control " hidden name="jam_kembali[]" value="<?= $val['jam_kembali'] ?>" readonly>
														<input type="text" class="form-control " hidden name="tdk_masuk_d_id[]" value="<?= $val['tdk_masuk_d_id'] ?>" readonly>
														<input type="text" class="form-control " hidden name="posisi_hari[]" value="<?= $val['hr'] ?>" readonly>
														<input type="text" class="form-control " hidden name="jml_awal" value="<?= $jml_awal ?>" readonly>
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
							<div class="col-sm-5">
								<button type="submit" class="btn btn-success mb-0">Approve</button>

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

<?php echo $this->load->assets('terlambat', 'approval_detail', 'js');  ?>

