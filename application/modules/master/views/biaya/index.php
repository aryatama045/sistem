<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>

<div class="row">
	<div class="col">

		<!-- Title and Top Buttons Start -->
		<div class="page-title-container">
			<div class="row">
				<!-- Title Start -->
				<div class="col-12 col-md-7">
					<h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?></h1>
					<?php $this->load->view('templates/breadcrumb'); ?>
				</div>
				<!-- Title End -->

				<!-- Top Buttons Start -->
				<div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
					<!-- Add New Button Start -->
					<a href="<?= base_url($mod.'/'.$func.'/tambah') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
						<i data-acorn-icon="plus"></i>
						<span>Add New</span>
					</a>
					<!-- Add New Button End -->
				</div>
				<!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->

		<!-- Controls Start -->
		<div class="row">
			<!-- Search Start -->
			<div class="col-sm-12 col-md-5 col-lg-9 col-xxl-9 mb-1">
				<div class="d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground">
					<!-- <input class="form-control" placeholder="Search" type="text" name="search_name" id="search_name" />
					<span class="search-magnifier-icon">
						<i data-acorn-icon="search"></i>
					</span>
					<span class="search-delete-icon d-none">
						<i data-acorn-icon="close"></i>
					</span> -->
				</div>
			</div>
			<!-- Search End -->

			<div class="col-sm-12 col-md-5 col-lg-3 col-xxl-3 text-end mb-1">
				<div class="d-inline-block me-0 me-sm-3 float-start float-md-none search-input-container w-100 shadow bg-foreground">
					<input class="form-control" placeholder="Search" type="text" name="search_name" id="search_name" />
					<span class="search-magnifier-icon">
						<i data-acorn-icon="search"></i>
					</span>
					<span class="search-delete-icon d-none">
						<i data-acorn-icon="close"></i>
					</span>
				</div>
			</div>
		</div>
		<!-- Controls End -->

		<?php $this->load->view('templates/notif') ?>

		<div class="card">
			<div class="card-body">
				<table id="<?= $table_data ?>" class="table table-bordered data-table data-table-pagination  responsive nowrap stripe w-100">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-uppercase">Kd Biaya</th>
							<th class="text-bold text-uppercase">Biaya</th>
							<th class="text-bold text-uppercase">Jenis</th>
							<th class="text-bold text-uppercase">Tahun Ajaran</th>
							<th class="text-bold text-uppercase">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</div>
</div>



<!-- remove modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form role="form" action="<?= base_url($mod.'/'.$func.'/delete') ?>" method="post" id="removeForm">
				<div id="id" class="modal-body">
					<p>Yakin <span></span> ?</p>
				</div>

				<div id="messages_modal_remove"></div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id='btn-delete'> Remove</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
	window.linkstore = '<?php echo $func.'/store' ?>';
    window.tableData = '<?= $table_data ?>'
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>

<?php echo $this->load->assets(to_strip(lowercase($pagetitle)), 'index', 'js');  ?>