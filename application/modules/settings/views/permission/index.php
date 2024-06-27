<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>

<style>
    th.sorting {
            display: none;
        }
</style>

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

                <div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
					<a href="<?= base_url($mod.'/general') ?>" class="btn btn-outline-info btn-icon btn-icon-start w-100 w-md-auto ">
						<i data-acorn-icon="back"></i>
						<span> Kembali</span>
					</a>
				</div>
			</div>
		</div>
		<!-- Title and Top Buttons End -->


        <?php $this->load->view('templates/notif') ?>


        <form action="<?= base_url($mod.'/'.$func.'/update') ?>" method="POST">
            <div class="row">

                <!-- List Role Start -->
                <div class="col-12 col-xl-4 mb-1">
                    <div class="card">
                        <div class="card-body scroll-out">
                            <h4 class="title text-black text-bold">List Role</h4>
                            <hr>
                            <div class="scroll sh-50">
                                <?php $i = 0; foreach( $dataRole as $val ) {$i++ ?>
                                    <div class="mb-2 scroll-item">
                                        <div class="row g-0 sh-1 " >
                                            <div class="col">
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="customRadio<?= $val['id'] ?>" name="search_role" value="<?= $val['id'] ?>" />
                                                    <label class="form-check-label" for="customRadio<?= $val['id'] ?>"> <strong> <?= capital(strtolower($val['name'])) ?> </strong></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- List Role END -->

                <!-- Menu Akses Start -->
                <div class="col-12 col-xl-8 mb-1">
                    <div class="card">
                        <div class="card-body ">

                            <div class="d-flex flex-row align-items-center mb-3">
                                <div class="row g-0 sh-6 align-self-start" >
                                    <div class="col">
                                        <div class="card-body d-flex flex-row pt-0 pb-0 pe-0 pe-0 ps-2 h-100 align-items-center justify-content-between">
                                            <div class="d-flex flex-column">
                                                <h4 class="title text-black text-bold">Menu Permission</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-icon  ms-1 ms-auto" data-bs-toggle="modal" data-bs-target="#largeRightModalExample">
                                    <i data-acorn-icon="plus"></i> Add Menu
                                </button>

                                <!-- <button type="button" class="btn btn-outline-primary btn-icon  ms-1">
                                    <i data-acorn-icon="plus"></i> Add Menu
                                </button> -->
                            </div>

                            <!-- <div class="separator-light mb-3"></div> -->
                            <!-- User End -->

                            <div class="search-input-container border border-separator rounded-md bg-foreground mb-4">
                                <input class="form-control search" type="text" autocomplete="off" placeholder="Search Menu Akses" name="search_name" id="search_name"  />
                                <span class="search-magnifier-icon">
                                    <i data-acorn-icon="search"></i>
                                </span>
                            </div>
                            <div class="scroll sh-60 mb-2">
                                <table id="<?= $table_data ?>"  class="table  responsive nowrap  w-100" >
                                    <label class="form-check w-100 checked-line-through checked-opacity-75">
                                        <input type="checkbox" id="selectAll" class="form-check-input" />
                                        Select All
                                    </label>
                                </table>
                            </div>

                            <!-- Save Buttons Start -->
                            <div class="d-flex align-items-start justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary btn-icon btn-icon-start w-100 w-md-auto ">
                                    <i data-acorn-icon="save"></i>
                                    <span> Save Permission</span>
                                </button>
                            </div>
                            <!-- Save Buttons END -->
                        </div>
                    </div>
                </div>
                <!-- Menu Akses END -->

            </div>
        </form>


	</div>
</div>

<div class="modal modal-right large fade" id="largeRightModalExample" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url($mod.'/'.$func.'/tambah'); ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title"><strong> Add Menu</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-black">Menu Name <span class="text-small" style="color:red">*</span></label>
                        <input name="menu_name" type="text" class="form-control" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-black">Icon</label>
                        <input name="icon" type="text" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-black">Parent Menu</label>
                        <select name="parent_id" class="select form-control" required>
                            <option value="">-- Select Parent --</option>
                            <option value="0"> Main Menu (Without Parent)</option>
                            <?php foreach ($dataMenu as $key => $val) {
                                if($val['parent_id'] == '0'){ ?>
                                <option value="<?= $val['id'] ?>"> <?= $val['display_name'] ?></option>
                            <?php } } ?>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <div class="form-check">
                            <input type="radio" id="category1" name="Category" value="Whole Wheat" class="form-check-input" />
                            <label class="form-check-label" for="category1">Whole Wheat</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="category2" name="Category" value="Sourdough" class="form-check-input" />
                            <label class="form-check-label" for="category2">Sourdough</label>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="form-check-label" ><strong> Note : </strong><span style="color:red">*</span> Wajib</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        <i data-acorn-icon="save"></i>
                        <span> Save Menu</span>
                    </button>
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
