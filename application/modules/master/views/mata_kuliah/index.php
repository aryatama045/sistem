
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

					<nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
						<ul class="breadcrumb pt-0">
							<li class="breadcrumb-item"><a href="<?php base_url(); ?>">Home</a></li>
							<li class="breadcrumb-item"><?= $modul ?></li>

							<?php if(!is_null($pagetitle)){ ?>
								<li class="breadcrumb-item"><?= $pagetitle ?></li>
							<?php } ?>

							<?php if(!is_null($function)){ ?>
								<li class="breadcrumb-item"><?= $function ?></li>
							<?php } ?>
						</ul>
					</nav>

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

		<!-- Table Start -->
		<div class="card">
			<div class="card-body">
				<table id="<?= $table_data ?>" class="table table-bordered data-table data-table-pagination responsive nowrap stripe w-100" >
					<thead >
						<tr>
							<th class="text-muted text-bold text-uppercase">Kode</th>
							<th class="text-muted text-bold text-uppercase">Program</th>
							<th class="text-muted text-bold text-uppercase">Mata kuliah</th>
                            <th class="text-muted text-bold text-uppercase">sks</th>
                            <th class="text-muted text-bold text-uppercase">semester</th>
                            <th class="text-muted text-bold text-uppercase">status</th>
							<th class="text-muted text-bold text-uppercase text-center">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<!-- Table End -->


	</div>
</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
	window.linkstore = '<?php echo $func.'/store' ?>';
    window.tableData = '<?= $table_data ?>'
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>

<?php echo $this->load->assets(to_strip(lowercase($pagetitle)), 'index', 'js');  ?>
