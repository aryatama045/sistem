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

				<!-- Top Buttons Start -->
				<div class="col-12 col-md-5 d-flex align-items-start justify-content-end">
					<!-- Add New Button Start -->
					<a href="<?= base_url($mod.'/'.$func.'/tambah') ?>" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto add-datatable">
						<i data-acorn-icon="save"></i>
						<span> Save Jadwal</span>
					</a>
					<!-- Add New Button End -->
				</div>
				<!-- Top Buttons End -->
			</div>
		</div>
		<!-- Title and Top Buttons End -->

        <div class="card mb-5">
            <div class="card-body">
                <div>
                    <h4 class="title text-black text-bold">Program Studi</h4>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_prodi" id="inlineRadio1" value="1">
                        <label class="form-check-label" for="inlineRadio1"> D3 - Optometri</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="search_prodi" id="inlineRadio2" value="2">
                        <label class="form-check-label" for="inlineRadio2"> S1 - Optometri</label>
                    </div>
                </div>
            </div>
        </div>


		<?php $this->load->view('templates/notif') ?>

        <div class="row">
            <!-- List Dosen Start -->
            <div class="col-12 col-xl-6 mb-5">
                <div class="card">
                    <div class="card-body scroll-out">
                        <h4 class="title text-black text-bold">List Dosen</h4>
                        <div class="search-input-container border border-separator rounded-md bg-foreground mb-4">
                        <input class="form-control search" type="text" autocomplete="off" placeholder="Search Dosen" name="nama_dosen" id="nama_dosen"  />
                            <span class="search-magnifier-icon">
                                <i data-acorn-icon="search"></i>
                            </span>
                        </div>
                        <div class="scroll sh-50">

                            <?php $i = 0; foreach( $dataDosen as $val ) {$i++ ?>
                                <div class="mb-2 scroll-item">
                                    <div class="row g-0 sh-10 sh-sm-7" >
                                        <div class="col-auto">
                                            <img src="<?= base_url('assets/') ?>img/profile/profile-6.webp" class="card-img rounded-xl sh-6 sw-6" alt="thumb" />
                                        </div>
                                        <div class="col">
                                            <div class="card-body d-flex flex-column flex-sm-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-sm-center justify-content-sm-between">
                                                <div class="d-flex flex-column mb-2 mb-sm-0">
                                                    <div><strong><?= $val['nama'] ?></strong></div>
                                                    <div class="text-black">Nip : <?= $val['nip'] ?></div>
                                                </div>
                                                <div class="d-flex">
                                                    <label class="form-check w-100">
                                                        <input type="radio" class="form-check-input" name="search_dosen" value="<?= $val['nip'] ?>" />
                                                    </label>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
            <!-- List Dosen End -->

            <!-- Mata Kuliah Start -->
            <div class="col-12 col-xl-6 mb-5">
                <div class="card">
                    <div class="card-body ">
                        <h4 class="title text-black text-bold">Mata Kuliah</h4>
                        <div class="search-input-container border border-separator rounded-md bg-foreground mb-4">
                            <input class="form-control search" type="text" autocomplete="off" placeholder="Search Mata Kuliah" name="search_name" id="search_name"  />
                            <span class="search-magnifier-icon">
                                <i data-acorn-icon="search"></i>
                            </span>
                        </div>
                        <div class="scroll sh-50">

                            <table id="<?= $table_data ?>"  class="table table-bordered data-table responsive nowrap stripe w-100" >

                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Mata Kuliah End -->
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