

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
				<h5 class="mb-4">Detail ( <?= $headerdok['no_faktur']; ?> )</h5>
				<div class="separator mb-4"></div>
				<form id="approve_detail" role="form" action="<?php base_url('leaves/berita_acara/detail') ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NO.FAKTUR</label>
								<div class="col-sm-8">
                                    <input hidden type="text" class="form-control" name="faktur_id" value="<?= $headerdok['faktur_id'] ?>" readonly>
									<input type="text" class="form-control" name="no_faktur" placeholder="<?= $headerdok['no_faktur'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NO. PR</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $headerdok['no_pr'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NIP/NAMA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $headerdok['pic_input'] ?> - <?= $headerdok['user_name'] ?>" readonly>
								</div>
							</div>
						</div>
                        <div class="col-lg-6">
                            <div class="form-group row">
								<label class="col-sm-4 col-form-label">BIAYA JASA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($nilaijasa['total_jasa']) ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">KETERANGAN</label>
								<div class="col-sm-8">
									<textarea class="form-control" cols="30" rows="2" readonly><?= $headerdok['keterangan'] ?></textarea>
								</div>
							</div>
                        </div>
					</div>
                    <hr>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php if (!empty($headerdok['r_lensa'])){ ?>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label d-flex justify-content-center text-center my-auto">
                                    <b>R Lensa (<?= $headerdok['r_lensa'] ?>)</b></label>
                                <div class="col-sm-2">
                                    <p class="text-muted mb-2">Harga Lama</p>
									<p><b><?= nominal($headerdok['old_r_harga']) ?></b></p>
                                    <p class="text-muted mb-2">Harga Baru</p>
									<p><b><?= nominal($headerdok['new_r_harga']) ?></b></p>
								</div>
                                <div class="col-sm-2">
                                    <p class="text-muted  mb-2">Diskon % Lama</p>
									<p class=""><b><?= diskon($headerdok['old_r_diskon_persen']) ?></b></p>
                                    <p class="text-muted  mb-2">Diskon % Baru</p>
									<p class=""><b><?= diskon($headerdok['new_r_diskon_persen']) ?></b></p>
								</div>
                                <div class="col-sm-2">
                                    <p class="text-muted mb-2">Total Diskon Lama</p>
									<p class=""><b><?= nominal($headerdok['old_r_diskon_total']) ?></b></p>
                                    <p class="text-muted mb-2">Total Diskon Baru</p>
									<p class=""><b><?= nominal($headerdok['new_r_diskon_total']) ?></b></p>
								</div>
                                <div class="col-sm-2 text-center">
                                    <p class="text-muted mb-2">Total Harga Lama</p>
									<p><b><?= nominal($headerdok['old_r_total']) ?></b></p>
								</div>
                                <div class="col-sm-2 text-center">
                                    <p class="text-muted mb-2">Total Harga Baru</p>
									<p><b><?= nominal($headerdok['new_r_total']) ?></b></p>
								</div>
							</div>
                            <hr>
                            <?php } ?>

                            <?php if (!empty($headerdok['l_lensa'])){ ?>
							<div class="form-group row">
                                <label class="col-sm-2 col-form-label d-flex justify-content-center text-center my-auto">
                                    <b>L Lensa (<?= $headerdok['l_lensa'] ?>)</b></label>
                                <div class="col-sm-2">
                                    <p class="text-muted mb-2">Harga Lama</p>
									<p><b><?= nominal($headerdok['old_l_harga']) ?></b></p>
                                    <p class="text-muted mb-2">Harga Baru</p>
									<p><b><?= nominal($headerdok['new_l_harga']) ?></b></p>
								</div>
                                <div class="col-sm-2">
                                    <p class="text-muted  mb-2">Diskon % Lama</p>
									<p class=""><b><?= diskon($headerdok['old_l_diskon_persen']) ?></b></p>
                                    <p class="text-muted  mb-2">Diskon % Baru</p>
									<p class=""><b><?= diskon($headerdok['new_l_diskon_persen']) ?></b></p>
								</div>
                                <div class="col-sm-2">
                                    <p class="text-muted mb-2">Total Diskon Lama</p>
									<p class=""><b><?= nominal($headerdok['old_l_diskon_total']) ?></b></p>
                                    <p class="text-muted mb-2">Total Diskon Baru</p>
									<p class=""><b><?= nominal($headerdok['new_l_diskon_total']) ?></b></p>
								</div>
                                <div class="col-sm-2 text-center">
                                    <p class="text-muted mb-2">Total Harga Lama</p>
									<p><b><?= nominal($headerdok['old_l_total']) ?></b></p>
								</div>
                                <div class="col-sm-2 text-center">
                                    <p class="text-muted mb-2">Total Harga Baru</p>
									<p><b><?= nominal($headerdok['new_l_total']) ?></b></p>
								</div>
							</div>
                            <hr>
                            <?php } ?>

                            <?php if (!empty($headerdok['r_lensa']) || !empty($headerdok['l_lensa'])){ ?>
                            <div class="form-group row">
                                <label class="col-sm-10 col-form-label d-flex justify-content-center text-center my-auto">
                                    <h5><b>GRAND TOTAL AKHIR </b></h5></label>
                                <div class="col-sm-2">
                                    <h5 class="d-flex justify-content-center text-center my-auto"><b><?=  nominal($total_akhir) ?></b></h5>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

					<hr>

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


<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
	var TableDetail;

	$(document).ready(function() {
		// initialize the datatable
		TableDetail = $('#TableDetail').DataTable({
			'processing': true,
			'scrollX': true,
		});

		$("#TableDetail_filter").css("display", "none");
		// $("#TableDetail_length").css("display", "none");
		$("#TableDetail_paginate").css("display", "none");
		$("#TableDetail_info").css("display", "none");

	});

</script>


