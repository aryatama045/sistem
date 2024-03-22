
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
			<h1>Approval Data Ijin</h1>
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
									<li id='#tableApprovalIjin'><a href="#table1">Aktif<br /></a></li>
									<li id='#tableApprovalIjinHistory'><a href="#table2"> History</a></li>
								</ul>
								<div class="card-body">
									<div id="table1">
										<!-- <div class="form-inline">
											<div class="input-group mb-2 mr-sm-2">
												<div class="input-group-prepend">
													<div class="input-group-text"><span class="search-icon"><i class="simple-icon-magnifier"></i></span></div>
												</div>
												<input type="text" data-column="2" class="search-input-text form-control" placeholder="Search by Nama Lengkap">
											</div>
										</div> -->
										<table id="ApprovalIjin" class="table table-bordered data-table mb-4">
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
											<div class="form-inline">
												<div class="input-group mb-2 mr-sm-2">
													<div class="input-group-prepend">
														<div class="input-group-text"><span class="search-icon"><i class="simple-icon-magnifier"></i></span></div>
													</div>
													<input type="text"  data-column="4" class="search-input-text form-control" placeholder="Search by Nama Lengkap">
												</div>
											</div>
										<table id="ApprovalIjinHistory" class="table table-bordered data-table mb-4">
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
<?php echo $this->load->assets('ijin', 'approval', 'js');  ?>

