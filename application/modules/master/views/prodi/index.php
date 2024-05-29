


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
					<button type="button" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
						<i data-acorn-icon="plus"></i>
						<span>Add New</span>
					</button>
					<!-- Add New Button End -->

					<!-- Check Button Start -->
					<div class="btn-group ms-1 check-all-container">
						<div class="btn btn-outline-primary btn-custom-control p-0 ps-3 pe-2" id="datatableCheckAllButton">
						<span class="form-check float-end">
							<input type="checkbox" class="form-check-input" id="datatableCheckAll" />
						</span>
						</div>
						<button
						type="button"
						class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
						data-bs-offset="0,3"
						data-bs-toggle="dropdown"
						aria-haspopup="true"
						aria-expanded="false"
						data-submenu
						></button>
						<div class="dropdown-menu dropdown-menu-end">
						<div class="dropdown dropstart dropdown-submenu">
							<button class="dropdown-item dropdown-toggle tag-datatable caret-absolute disabled" type="button">Tag</button>
							<div class="dropdown-menu">
							<button class="dropdown-item tag-done" type="button">Done</button>
							<button class="dropdown-item tag-new" type="button">New</button>
							<button class="dropdown-item tag-sale" type="button">Sale</button>
							</div>
						</div>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item disabled delete-datatable" type="button">Delete</button>
						</div>
					</div>
					<!-- Check Button End -->
				</div>
				<!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->


		<!-- Controls Start -->
		<div class="row">
			<!-- Search Start -->
			<div class="col-sm-12 col-md-5 col-lg-3 col-xxl-2 mb-1">
				<div class="d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground">
					<input class="form-control" placeholder="Search" type="text" name="search_name" id="search_name" />
					<span class="search-magnifier-icon">
						<i data-acorn-icon="search"></i>
					</span>
					<span class="search-delete-icon d-none">
						<i data-acorn-icon="close"></i>
					</span>
				</div>
			</div>
			<!-- Search End -->

			<div class="col-sm-12 col-md-7 col-lg-9 col-xxl-10 text-end mb-1">
				<div class="d-inline-block me-0 me-sm-3 float-start float-md-none">
					<!-- Add Button Start -->
					<button
						class="btn btn-icon btn-icon-only btn-foreground-alternate shadow add-datatable"
						data-bs-delay="0"
						data-bs-toggle="tooltip"
						data-bs-placement="top"
						title="Add"
						type="button"
						>
						<i data-acorn-icon="plus"></i>
					</button>
					<!-- Add Button End -->

					<!-- Edit Button Start -->
					<button
						class="btn btn-icon btn-icon-only btn-foreground-alternate shadow edit-datatable "
						data-bs-delay="0"
						data-bs-toggle="tooltip"
						data-bs-placement="top"
						title="Edit"
						type="button"
						>
						<i data-acorn-icon="edit"></i>
					</button>
					<!-- Edit Button End -->

					<!-- Delete Button Start -->
					<button
						class="btn btn-icon btn-icon-only btn-foreground-alternate shadow disabled delete-datatable"
						data-bs-delay="0"
						data-bs-toggle="tooltip"
						data-bs-placement="top"
						title="Delete"
						type="button"
						>
						<i data-acorn-icon="bin"></i>
					</button>
					<!-- Delete Button End -->
				</div>
				<div class="d-inline-block">
					<!-- Print Button Start -->
					<button
						class="btn btn-icon btn-icon-only btn-foreground-alternate shadow datatable-print"
						data-bs-delay="0"
						data-datatable="#RowsAjaxTA"
						data-bs-toggle="tooltip"
						data-bs-placement="top"
						title="Print"
						type="button"
						>
						<i data-acorn-icon="print"></i>
					</button>
					<!-- Print Button End -->

					<!-- Export Dropdown Start -->
					<div class="d-inline-block datatable-export" data-datatable="#RowsAjaxTA">
						<button class="btn p-0" data-bs-toggle="dropdown" type="button" data-bs-offset="0,3">
							<span
							class="btn btn-icon btn-icon-only btn-foreground-alternate shadow dropdown"
							data-bs-delay="0"
							data-bs-placement="top"
							data-bs-toggle="tooltip"
							title="Export"
							>
							<i data-acorn-icon="download"></i>
							</span>
						</button>
						<div class="dropdown-menu shadow dropdown-menu-end">
							<button class="dropdown-item export-copy" type="button">Copy</button>
							<button class="dropdown-item export-excel" type="button">Excel</button>
							<button class="dropdown-item export-cvs" type="button">Cvs</button>
						</div>
					</div>
					<!-- Export Dropdown End -->

				</div>
			</div>
		</div>
		<!-- Controls End -->

		<!-- Table Start -->
		<div class="card">
			<div class="card-body">
                <?php $table_data = to_strip($pagetitle);  ?>
				<table id="<?= $table_data ?>" class="table table-bordered data-table data-table-pagination responsive nowrap stripe w-100" >
					<thead >
						<tr>
							<th class="text-muted text-bold text-uppercase">KD. PROG</th>
							<th class="text-muted text-bold text-uppercase">Nama Program</th>
							<th class="text-muted text-bold text-uppercase">Jenjang</th>
							<th class="text-muted text-bold text-uppercase">Action</th>
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
	<?php $mod = lowercase($modul); $func = to_strip($pagetitle);  ?>
	window.linkstore = '<?php echo $func.'/store' ?>';
    window.tableData = '<?= $table_data ?>'
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>

<?php echo $this->load->assets($func, 'index', 'js');  ?>
