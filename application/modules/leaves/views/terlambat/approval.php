
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
			<h1>Approval Data Terlambat</h1>
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
							<div id="clickable1">
								<div id="smartWizardClickTable">

								<ul class="card-header ">
									<li id='#tableApprovalTerlambat'><a href="#table1">Aktif<br /></a></li>
									<li id='#tableApprovalTerlambatHistory'><a href="#table2"> History</a></li>
								</ul>
								<div class="card-body">
									<div id="table1">
										<table id="ApprovalTerlambat" class="table table-bordered data-table mb-4">
											<thead>
												<tr>
													<th>Detail</th>
													<th>NO.DOK </th>
													<th>NAMA</th>
													<th>KETERANGAN</th>
													<th>TGL.DOK</th>
													<th class="empty">&nbsp;</th>
												</tr>
											</thead>
										</table>
									</div>
									<div id="table2">
											<table id="ApprovalTerlambatHistory" class="table table-bordered data-table mb-4">
												<thead>
													<tr>
														<th>DETAIL</th>
														<th>NO.DOK</th>
														<th>TGL DOK</th>
														<th>NIP</th>
														<th>NAMA LENGKAP</th>
														<th>DEPT</th>
														<th>TGL APPRV/REJECT</th>
														<th>STATUS</th>
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
	</div>


<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('terlambat', 'approval', 'js');  ?>

