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
								<label class="col-sm-5 col-form-label">NO DOKUMEN</label>
								<div class="col-sm-6">
									<input type="text" id="no_doc" name="no_doc" class="form-control" value="<?= $header_data['header']['no_doc'] ?>" readonly>
									<!-- <input type="text" hidden name="jml_app" class="form-control" value="<?= $header_data['header']['jml_app'] ?>" readonly> -->
									<!-- <input type="text" hidden name="urutan_approval" class="form-control" value="<?= $header_data['header']['urutan_approval'] ?>" readonly> -->
									<!-- <input type="text" hidden name="biodata_id" class="form-control" value="<?= $header_data['header']['biodata_id'] ?>" readonly> -->
									<!-- <input type="text" hidden name="tgl_akhir" class="form-control" value="<?= $header_data['header']['tgl_akhir'] ?>" readonly> -->
								</div>
							</div>
							<div class="form-group row"> 
								<label class="col-sm-5 col-form-label">TGL DOKUMEN </label>
								<div class="col-sm-6">
									<input type="date" id="tgl_doc" name="tgl_doc" class="form-control" disabled value="<?= $header_data['header']['tgl_doc'] ?>" placeholder="Pilih Tanggal Awal Berlaku">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NIP</label>
								<div class="col-sm-6">
									<input disabled type="text" id="nip" name="nip" class="form-control" value="<?= $header_data['header']['nip'] ?>" disabled>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NAMA</label>
								<div class="col-sm-6">
									<input disabled type="text" id="nama" name="nama" class="form-control" value="<?= $header_data['header']['nama_lengkap'] ?>" disabled>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">TANGGAL MASUK</label>
								<div class="col-sm-6" type="text">
									<input disabled id="tgl_awal" name="tgl_awal" class="form-control" value="<?= $header_data['header']['tgl_awal'] ?>" placeholder="Pilih Tanggal Masuk">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">DOK. OVERTIME</label>
								<div class="col-sm-6" type="text">
									<input disabled id="dok_overtime" name="dok_overtime" class="form-control" value="<?= $dok_overtime ?>">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JAM MASUK : </label>
								<div class="col-sm-6">
									<input id="jam_masuk" name="jam_masuk" placeholder="<?= $tgl_jam_masuk['jam_masuk'] ?>" class="form-control"  disabled></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JAM KELUAR : </label>
								<div class="col-sm-6">
									<input id="jam_keluar" name="jam_keluar" placeholder="<?= $tgl_jam_keluar['jam_keluar'] ?>" class="form-control" disabled></textarea>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">SELISIH WAKTU : </label>
								<!-- <div class="col-sm-6">
									<?php 	//$awal  = new DateTime($header_data['header']['jam_masuk']); //Waktu awal
											//$akhir = new DateTime($header_data['header']['jam_keluar']); // Waktu sekarang atau akhir
											//$diff  = $akhir->diff($awal);?>
									<input id="selisih" name="selisih" placeholder="<?php //echo $diff->h . ' Jam : ' . $diff->i . ' Menit : ' .$diff->s. ' Detik' ?>" class="form-control" disabled></textarea>
								</div> -->

								<div class="col-sm-6">
									<?php
											$tgl_masuk 		= strtotime($tgl_jam_masuk['tgl_masuk'].' '.$tgl_jam_masuk['jam_masuk']);
											$tgl_keluar 	= strtotime($tgl_jam_keluar['tgl_keluar'].' '.$tgl_jam_keluar['jam_keluar']);
											$diff  = $tgl_keluar-$tgl_masuk;
											$jam   = floor($diff / (60 * 60));
											$menit = $diff - ( $jam * (60 * 60) );
											$detik = $diff % 60;
											?>
									<input id="selisih" name="selisih" placeholder="<?= $jam . ' Jam : ' . floor( $menit / 60 ) . ' Menit : ' .$detik. ' Detik' ?>" class="form-control" disabled></textarea>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JUMLAH HARI</label>
								<div class="col-sm-6" >
									<input id="tgl_awal" name="jml_hari" class="form-control" value="<?= $header_data['header']['jml_hari'] ?>" placeholder="Pilih Tanggal Masuk" disabled>

								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">KETERANGAN</label>
								<div class="col-sm-6">
									<textarea disabled id="keterangan" name="keterangan" class="form-control" value="<?= $header_data['header']['keterangan'] ?>"><?= $header_data['header']['keterangan'] ?></textarea>
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


