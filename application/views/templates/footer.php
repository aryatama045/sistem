

		</div>
	</main>

	<hr>
	<footer>
		<div class="footer-content">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-6">
						<p class="mb-0 text-muted">
						Copyright &copy; <?= date('Y') ?>
						| <?= (ENVIRONMENT!='production')?ENVIRONMENT:""?>
						| <b>CI</b> <?php echo CI_VERSION; ?>
						| <?= $this->agent->platform() ?>
						| <?= $this->input->ip_address() ?>
						| <?= gethostname() ?>
						| <?= $this->agent->browser() ?>
						| <?= $this->agent->version() ?>
						</p>
					</div>
					<div class="col-sm-6 d-none d-sm-block">
						<ul class="breadcrumb pt-0 pe-0 mb-0 float-end">
							<li class="breadcrumb-item mb-0 text-medium">
								<a href="#" class="btn-link">Review</a>
							</li>
							<li class="breadcrumb-item mb-0 text-medium">
								<a href="#" class="btn-link">Docs</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>

	<!-- Search Modal Start -->
	<div class="modal fade modal-under-nav modal-search modal-close-out" id="searchPagesModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header border-0 p-0">
					<button type="button" class="btn-close btn btn-icon btn-icon-only btn-foreground" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body ps-5 pe-5 pb-0 border-0">
					<input id="searchPagesInput" class="form-control form-control-xl borderless ps-0 pe-0 mb-1 auto-complete" type="text" autocomplete="off" />
				</div>
				<div class="modal-footer border-top justify-content-start ps-5 pe-5 pb-3 pt-3 border-0">
					<span class="text-alternate d-inline-block m-0 me-3">
						<i data-acorn-icon="arrow-bottom" data-acorn-size="15" class="text-alternate align-middle me-1"></i>
						<span class="align-middle text-medium">Navigate</span>
					</span>
					<span class="text-alternate d-inline-block m-0 me-3">
						<i data-acorn-icon="arrow-bottom-left" data-acorn-size="15" class="text-alternate align-middle me-1"></i>
						<span class="align-middle text-medium">Select</span>
					</span>
				</div>
			</div>
		</div>
	</div>
	<!-- Search Modal End -->

	<!-- Vendor Scripts Start -->
	<script src="<?= base_url('assets/') ?>js/vendor/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/OverlayScrollbars.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/autoComplete.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/clamp.min.js"></script>
    <script src="<?= base_url('assets/') ?>icon/acorn-icons.js"></script>
    <script src="<?= base_url('assets/') ?>icon/acorn-icons-interface.js"></script>
	<script src="<?= base_url('assets/') ?>icon/acorn-icons-learning.js"></script>
    <script src="<?= base_url('assets/') ?>icon/acorn-icons-commerce.js"></script>
	<script src="<?= base_url('assets/') ?>icon/acorn-icons-medical.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/jquery.validate/jquery.validate.min.js"></script>
    <script src="<?= base_url('assets/') ?>js/vendor/jquery.validate/additional-methods.min.js"></script>

	<script src="<?= base_url('assets/') ?>js/vendor/bootstrap-submenu.js"></script>

    <script src="<?= base_url('assets/') ?>js/vendor/datatables.min.js"></script>

	<script src="<?= base_url('assets/') ?>js/cs/datatable.extend.js"></script>

    <!-- Vendor Scripts End -->

    <!-- Template Base Scripts Start -->
    <script src="<?= base_url('assets/') ?>js/base/helpers.js"></script>
    <script src="<?= base_url('assets/') ?>js/base/globals.js"></script>
    <script src="<?= base_url('assets/') ?>js/base/nav.js"></script>
    <script src="<?= base_url('assets/') ?>js/base/search.js"></script>
    <script src="<?= base_url('assets/') ?>js/base/settings.js"></script>
    <!-- Template Base Scripts End -->

    <!-- Page Specific Scripts Start -->
    <script src="<?= base_url('assets/') ?>js/common.js"></script>
    <script src="<?= base_url('assets/') ?>js/scripts.js"></script>
    <!-- Page Specific Scripts End -->


</body>
</html>