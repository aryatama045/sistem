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

			</div>
		</div>
		<!-- Title and Top Buttons End -->

        <?php $this->load->view('templates/notif') ?>

		<div class="row">

			<?php foreach($getMenus as $val){ ?>
			<!-- Icons Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url(''.$val['link'].'') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="<?= $val['icon'] ?>" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold"><?= $val['display_name'] ?></div>
									<div class="text-small text-black"><?= $val['description'] ?></div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons End -->
			<?php } ?>

		</div>

		<div class="row" hidden>
			<!-- Icons Apart Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('settings/general/edit'); ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="cupcake" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">General Info</div>
									<div class="text-small text-black">Setup Info General Akademik.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons Apart End -->

			<!-- Icons Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('master/tahun_ajaran') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="presentation" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">Tahun Ajaran</div>
									<div class="text-small text-black">Setup Tahun Ajaran Aktif.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons End -->

			<!-- Icons Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('master/tahun_ajaran') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="presentation" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">Periode PMB</div>
									<div class="text-small text-black">Setup Masa Berlaku Periode PMB.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons End -->

			<!-- Icons Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('master/tahun_ajaran') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="presentation" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">Jam Absensi</div>
									<div class="text-small text-black">Setup Jam Absensi.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons End -->

			<!-- Icons Apart Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('settings/user_staff') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="cupcake" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">User Staff</div>
									<div class="text-small text-black">Manage User Akses.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons Apart End -->

			<!-- Icons Apart Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('settings/approval') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="cupcake" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">Approval</div>
									<div class="text-small text-black">Setup Approve User.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons Apart End -->

			<!-- Icons Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('settings/role') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="presentation" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">Role </div>
									<div class="text-small text-black">Setup User Role.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons End -->

			<!-- Icons Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('settings/permission') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="presentation" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">Menu Permission</div>
									<div class="text-small text-black">Setup User Menu Akses.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons End -->


			<!-- Icons Start -->
			<div class="col-xl-3 mb-1">
				<div class="card">
					<a href="<?= base_url('settings/generate_krs') ?>" class="row g-0 sh-10">
						<div class="col-auto">
							<div class="sw-9 sh-10 d-inline-block d-flex justify-content-center align-items-center">
								<i data-acorn-icon="form-check" class="text-primary"></i>
							</div>
						</div>
						<div class="col">
							<div class="card-body d-flex flex-column ps-0 pt-0 pb-0 h-100 justify-content-center">
								<div class="d-flex flex-column">
									<div class="title text-black fw-bold">Generate KRS Mahasiswa</div>
									<div class="text-small text-black">Setup KRS/Mahasiswa.</div>
								</div>
							</div>
						</div>
					</a>
				</div>
			</div>
			<!-- Icons End -->



		</div>

	</div>
</div>

<style>
	/* .footer-content {
	position: absolute;
	bottom: 0;
	height: 6.5rem;
	} */
</style>
<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
	window.linkstore = '<?php echo $func.'/store' ?>';
    window.tableData = '<?= $table_data ?>'
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>

<?php echo $this->load->assets(to_strip(lowercase($pagetitle)), 'index', 'js');  ?>
