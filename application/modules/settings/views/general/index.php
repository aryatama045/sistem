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

        


    </div>
</div>