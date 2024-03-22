<style>
		.btn-toolbar.sw-toolbar.sw-toolbar-bottom.justify-content-end {
			display: none;
		}
		.dataTables_scrollHeadInner{
			width: 100% !important;
		}

	</style>
	<div class="row">
		<div class="col-12">
			<h1>Approval Data Cuti Pengganti</h1>
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
								<table id="manageApproval" data-width="100%" class="table table-bordered data-table mb-4">
									<thead>
										<tr>
											<th>NO.DOK</th>
											<th>TGL DOK </th>
											<th>NIP</th>
											<th>NAMA</th>
											<th class="empty">&nbsp;</th>
										</tr>
									</thead>
								</table>
							</div>
							<div id="clickable2">
								<div class="form-inline">
									<div class="input-group mb-2 mr-sm-2">
										<div class="input-group-prepend">
											<div class="input-group-text">
												<span class="search-icon">
													<i class="simple-icon-magnifier"></i>
												</span>
											</div>
										</div>
										<input type="text" data-column="3" class="search-input-text form-control" placeholder="Search by Nama Lengkap">
									</div>
								</div>
								<table id="manageHistoryCutiPengganti" data-width="100%" class="table table-bordered data-table mb-4">
									<thead>
										<tr>
											<th>NO.DOK</th>
											<th>TGL DOK</th>
											<th>NIP</th>
											<th>NAMA</th>
											<th>JML HARI</th>
											<th>KET</th>
											<th>TGL APP/REJECT</th>
											<th>JAM IN</th>
											<th>JAM OUT</th>
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

<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('cuti_tambahan', 'approval', 'js');  ?>
