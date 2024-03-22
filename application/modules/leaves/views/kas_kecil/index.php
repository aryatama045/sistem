
<style>
	td.details-control {
		background: url('././theme/assets/details_open.png') no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url('././theme/assets/details_close.png') no-repeat center center;
	}

	.btn-toolbar.sw-toolbar.sw-toolbar-bottom.justify-content-end {
		display: none;
	}

	.dataTables_scrollHeadInner{
			width: 100% !important;
		}
</style>

	<div class="row">
		<div class="col-12">
			<h1>Approval Kas Kecil - Dept Head</h1>
			<div class="separator"></div>
			<br>
		</div>
	</div>

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

	<div class="row">
		<div class="col-12 ">
			<div class="card">

				<div class="card-body">
					<div id="smartWizardClickable">
						<ul class="card-header">
							<li><a href="#clickable1">Aktif<br /></a></li>
							<li><a href="#clickable2">History<br /></a></li>
						</ul>
						<hr>
						<div class="card-body">
							<div id="clickable1">
								<table id="manageKas" class="table table-bordered data-table">
									<thead>
										<tr>
											<th>NO.REQUEST </th>
											<th>NAMA REQ.</th>
											<th>JENIS</th>
											<th>KETERANGAN</th>
											<th>TOTAL</th>
											<th>TANGGAL </th>
											<th class="empty">&nbsp;</th>
										</tr>
									</thead>
								</table>
							</div>

							<div id="clickable2">
								<table id="manageHistory" class="table table-bordered data-table">
									<thead >
										<tr>
											<th class="empty">&nbsp;</th>
											<th>NO.REQUEST</th>
											<th>NAMA REQ.</th>
											<th>JENIS</th>
											<th>KETERANGAN</th>
											<th>TOTAL</th>
											<th>TANGGAL </th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<form action="kas_kecil/reject" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">NO. REQUEST</label>
						<div class="col-sm-8">
							<input name="no_request" placeholder="No Request" class="form-control" type="text" readonly>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-4 col-form-label">NAMA REQUEST</label>
						<div class="col-sm-8">
							<input name="nama_req" placeholder="Nama Request" class="form-control" type="text" readonly>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">KETERANGAN REJECT</label>
						<div class="col-sm-8">
							<textarea name="ket" class="form-control"  rows="5" required></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger"> Reject</button>
				</div>
			</div>
			</fom>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="DetailReport" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="DetailReportLabel">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p id="header_report"></p>
					<p id="data_report"></p>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"
						data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('kas_kecil', 'approval', 'js');  ?>

