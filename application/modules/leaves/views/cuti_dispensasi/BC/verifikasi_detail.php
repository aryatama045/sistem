

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
				<h3 class="mb-4">Verifikasi Cuti Dispensasi - <?= $header_data['header']['no_dok_cuti'] ?></h3>
				<div class="separator mb-4"></div>
				<form role="form" action="<?php base_url('leaves/cuti_dispensasi/verifikasi_detail') ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NO.DOC</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="no_doc" value="<?= $header_data['header']['no_dok_cuti'] ?>" readonly>
									<input type="text" hidden class="form-control" name="cuti_dispensasi_h_id" value="<?= $header_data['header']['cuti_dispensasi_h_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="cuti_dispensasi_h_id_r" value="<?= $header_data['header']['cuti_dispensasi_h_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="biodata_id" value="<?= $header_data['header']['biodata_id'] ?>" readonly>
									<!-- <input type="text" hidden class="form-control" name="urutan_approval" value="<?= $header_data['header']['urutan_approval'] ?>" readonly>
									<input type="text" hidden class="form-control" name="jml_app" value="<?= $header_data['header']['jml_app'] ?>" readonly> -->
									<input type="text" hidden class="form-control" name="kode_status_absensi" value="<?= $header_data['header']['kode_status_absensi'] ?>" readonly>


									<?php if($kodestore['kd_store']!=='' && $kodestore['kd_store']!==null){ ?>
										<input type="text" hidden class="form-control" name="kode_store" value="<?= $kodestore['kd_store'] ?>" readonly>
									<?php }else{ ?>
										<input type="text" hidden class="form-control" name="kode_store" value="OT_HO" readonly>
									<?php } ?>
									<input type="text" hidden class="form-control" name="gol_absensi_h_id" value="<?= $golabsen['gol_absensi_h_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="kode_gol_absensi" value="<?= $golabsen['kode_gol_absensi'] ?>" readonly>
									<input type="text" hidden class="form-control" name="gol_absensi_d_id" value="<?= $golabsen['gol_absensi_d_id'] ?>" readonly>
									<input type="text" hidden class="form-control" name="hari" value="<?= $golabsen['hari'] ?>" readonly>
									<input type="text" hidden class="form-control" name="jam_masuk" value="<?= $golabsen['jam_masuk'] ?>" readonly>
									<input type="text" hidden class="form-control" name="jam_keluar" value="<?= $golabsen['jam_keluar'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">TGL. DOK</label>
								<div class="col-sm-7">
									<div class="input-group">
										<span class="input-group-text input-group-append input-group-addon">
											<i class="simple-icon-calendar"></i>
										</span>
										<input type="text" class="form-control" name="tgl_dok_cuti" readonly value="<?= $header_data['header']['tgl_dok_cuti'] ?>">
									</div>
								</div>
							</div>
							<div hidden class="form-group row">
								<label class="col-sm-5 col-form-label">TGL.CUTI DOKTER</label>
								<div class="col-sm-7">
									<div class="input-group">
										<span class="input-group-text input-group-append input-group-addon">
											<i class="simple-icon-calendar"></i>
										</span>
										<input type="text" class="form-control" readonly name="tgl_cuti_dokter" value="<?= $header_data['header']['tgl_cuti_dokter'] ?>">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">TGL.MULAI CUTI</label>
								<div class="col-sm-7">
									<div class="input-group">
										<span class="input-group-text input-group-append input-group-addon">
											<i class="simple-icon-calendar"></i>
										</span>
										<input type="text" name="tgl_mulai_cuti" class="form-control" readonly value="<?= $header_data['header']['tgl_mulai_cuti'] ?>">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JENIS CUTI</label>
								<div class="col-sm-7">
								<input type="text" class="form-control" name="status_cuti" value="<?= $header_data['header']['jenis_cuti'] ?>" readonly>
								</div>
							</div>
							<div hidden class="form-group row">
								<label class="col-sm-5 col-form-label">NO.REFF</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="noreff" readonly value="<?= $header_data['header']['no_ref'] ?>">
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
							<div class="form-group row">
								<?php if ($header_data['header']['tj_sukacita']!="00.0"){ ?>
									<label class="col-sm-5 col-form-label">TJ.SUKACITA</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" readonly value="<?= $header_data['header']['tj_sukacita'] ?>">
									</div>
								<?php } else{ ?>
									<label class="col-sm-5 col-form-label">TJ.DUKACITA</label>
									<div class="col-sm-6">
										<input type="text" class="form-control" readonly value="<?= $header_data['header']['tj_dukacita'] ?>">
									</div>
								<?php } ?>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">TGL.KLAIM</label>
								<div class="col-sm-6">
									<div class="input-group ">
										<span class="input-group-text input-group-append input-group-addon">
											<i class="simple-icon-calendar"></i>
										</span>
										<input type="text" class="form-control" name="tgl_klaim" readonly value="<?= $header_data['header']['tgl_klaim'] ?>">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label"><b>LAMPIRAN 1</b></label>
								<div class="col-sm-6">
									<a class="test-popup-link"
										href="<?php echo base_url('upload/ijin/'.$header_data['header']['file_1']) ?>">
										<img src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_1']) ?>" 
										width="90px">
									</a>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label"><b>LAMPIRAN 2</b></label>
								<div class="col-sm-6">
									<a class="test-popup-link"
										href="<?php echo base_url('upload/ijin/'.$header_data['header']['file_2']) ?>">
										<img src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_2']) ?>" 
										width="90px">
									</a>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label"><b>LAMPIRAN 3</b></label>
								<div class="col-sm-6">
									<a class="test-popup-link"
										href="<?php echo base_url('upload/ijin/'.$header_data['header']['file_3']) ?>">
										<img src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_3']) ?>" 
										width="90px">
									</a>
								</div>
							</div>
						</div>
					</div>

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
														<input type="date" class="form-control " name="tgl_cuti[]" value="<?= $val['tgl_cuti'] ?>" >
													</div>
												</td>

												<!-- <td><input id="keterangan" class="form-control" readonly name="posisi_hari[]" value="<?= $val['hr'] ?>" type="text" /></td> -->

												<td><input id="keterangan" class="form-control" readonly name="keterangan_d[]" value="<?= $val['keterangan'] ?>" type="text" /></td>
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
							<div class="col-sm-4">
								<button onclick="history.go(-1); return false;" class="btn btn-primary mb-0"> Kembali</button>
							</div>
							<div class="col-sm-4">
								<button type="button" class="btn btn-danger mb-0" data-toggle="modal"
                                data-target="#exampleModal" data-whatever="@getbootstrap">Reject</button>
							</div>
							<div class="col-sm-4">
								<button type="submit" class="btn btn-success mb-0">Approve</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Reject - <?= $header_data['header']['no_dok_cuti'] ?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
			<form action="<?php base_url('leaves/cuti_dispensasi/verifikasi_detail') ?>" method="post" class="form-horizontal">
				<div class="modal-body">
					<div class="form-group">
						<input type="text" hidden class="form-control" name="cuti_dispensasi_h_id_r" value="<?= $header_data['header']['cuti_dispensasi_h_id'] ?>" readonly>
						<input type="text" class="form-control" name="no_doc" value="<?= $header_data['header']['no_dok_cuti'] ?>" readonly>
						<label for="message-text" class="col-form-label">Keterangan Reject :</label>
						<textarea class="form-control" name="alasan_reject" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger"> Reject</button>
				</div>
			</form>
		</div>
	</div>
</div>



