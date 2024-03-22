

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
				<h5 class="mb-4">Detail - <?= $headerdok['no_request']; ?></h5>
				<div class="separator mb-4"></div>
				<form id="approve_detail" role="form" action="<?php base_url('leaves/kas_kecil/approve_detail') ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NO.REQUEST</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_request" value="<?= $headerdok['no_request'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">JENIS</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $headerdok['jenis'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA REQ.</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $headerdok['nip_req'] ?> - <?= $headerdok['nama_req'] ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">DEPT REQ</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $headerdok['kode_dept_req'] ?>" readonly>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label">SUPPLIER</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= $headerdok['nama_supplier'] ?>" readonly>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label">KETERANGAN</label>
								<div class="col-sm-8">
									<textarea class="form-control" cols="30" rows="2" readonly><?= $headerdok['keterangan'] ?></textarea>
								</div>
							</div>

						</div>

						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NO.REQUEST UM</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_um" value="<?= $headerdok['no_um'] ?>" readonly>
								</div>
							</div>
							<!-- <div class="form-group row">
								<label class="col-sm-4 col-form-label">TOTAL BIAYA SEBELUMNYA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($headerdok['total_biaya_sebelumnya']) ?>" readonly>
								</div>
							</div> -->
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">TOTAL BIAYA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($headerdok['total_um']) ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">TOTAL UANG MUKA</label>
								<div class="col-sm-8">
									<input type="text" class="form-control"  placeholder="<?= nominal($headerdok['total_biaya']) ?>" readonly>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<!-- Table Approval -->
					<div class="col-lg-12s">
								<table id="TableDetailKas" width="100%" class="table table-striped table-responsive data-table table-condensed">
									<thead>
										<tr>
											<th>Kode Biaya</th>
											<th>Biaya</th>
											<th>Keterangan</th>
											<th>Periode Awal-Akhir</th>
											<th>Qty</th>
											<th>Satuan</th>
											<th>Harga Satuan</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($detaildok as $val){ ?>
										<tr>
											<td><?= $val['kode_biaya'] ?></td>
											<td><?= $val['nama_biaya'] ?></td>
											<td><?= $val['keterangan'] ?></td>
											<td><?= $val['periode_awal'] ?>/<?= $val['periode_akhir'] ?></td>
											<td><?= $val['qty'] ?></td>
											<td><?= $val['satuan'] ?></td>
											<td><?= nominal($val['harga_satuan']) ?></td>
											<td><b><?= nominal($val['total']) ?></b></td>
										</tr>
										<?php
											$sum_qty += $val['qty'];
											$sum_total += $val['total'];
										} ?>
									</tbody>
									<tfoot>
										<tr>
											<th colspan="4"></th>
											<th><?= $sum_qty; ?></th>
											<th colspan="2"></th>
											<th><?= nominal($sum_total); ?></th>
										</tr>
									</tfoot>
								</table>
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
	var TableDetailKas;

	$(document).ready(function() {
		// initialize the datatable
		TableDetailKas = $('#TableDetailKas').DataTable({
			'processing': true,
			'scrollX': true,
		});

		$("#TableDetailKas_filter").css("display", "none");
		// $("#TableDetailKas_length").css("display", "none");
		$("#TableDetailKas_paginate").css("display", "none");
		$("#TableDetailKas_info").css("display", "none");

	});

</script>


