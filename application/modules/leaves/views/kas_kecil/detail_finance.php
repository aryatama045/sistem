

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
				<h5 class="mb-4">Detail - <?= $detaildok['no_request']; ?></h5>
				<div class="separator mb-4"></div>
				<form id="approve_detail" role="form" action="<?php base_url('leaves/kas_kecil/detail_finance') ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NO.REQUEST</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_request" value="<?= $detaildok['no_request'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA BIAYA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $detaildok['nama_biaya'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">CABANG</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $detaildok['subcabang'] ?> - <?= $detaildok['singkatan_cabang'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">DIVISI REQ</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $detaildok['kode_divisi_req'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">PERIODE</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $detaildok['periode_awal'] ?> - <?= $detaildok['periode_akhir'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">KODE BIAYA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $detaildok['kode_biaya'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">SATUAN</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $detaildok['satuan'] ?>" readonly>
								</div>
							</div>
							<!-- <div class="form-group row">
								<label class="col-sm-4 col-form-label"></label>
								<label class="col-sm-4 col-form-label">Nilai BM = <?= $detaildok['nilai_bm'] ?></label>
								<label class="col-sm-4 col-form-label">Nilai BK = <?= $detaildok['nilai_bk'] ?></label>
							</div> -->

						</div>

						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">QTY</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $detaildok['qty'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">HARGA SEBELUMNYA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($detaildok['harga_satuan_sebelumnya']) ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">HARGA SATUAN</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($detaildok['harga_satuan']) ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">REALISASI</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($detaildok['realisasi']) ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">TOTAL</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($detaildok['total'] )?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">KETERANGAN</label>
								<div class="col-sm-8">
									<textarea class="form-control" cols="30" rows="2" readonly><?= $detaildok['keterangan'] ?></textarea>
								</div>
							</div>

						</div>
					</div> <hr>

					<div class="row">
						<div class="form-group row mb-0">
							<div class="col-sm-5">
								<button onclick="history.go(-1); return false;" class="btn btn-primary mb-0"> Kembali</button>
							</div>
								<br><br>
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
