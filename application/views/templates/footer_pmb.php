


<hr>
	<footer>
		<div class="footer-content">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-6">
						<p class="mb-0 text-muted">
						Copyright &copy; <?= date('Y') ?>
						| Tahun Ajaran : <?= $tahun_ajaran ?> - Semeseter <?= $semester ?>
						| <?= (ENVIRONMENT!='production')?ENVIRONMENT:""?>
						| <b>CI</b> <?php echo CI_VERSION; ?>
						| <?= $this->agent->platform() ?>
						| <?= $this->input->ip_address() ?>
						| <?= gethostname() ?>
						| <?= $this->agent->browser() ?>
						| <?= $this->agent->version() ?>
						<br>
						| Page Loader <?=  $this->benchmark->elapsed_time(); ?>
						| Memory <?=  $this->benchmark->memory_usage(); ?>
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

	</div>
	</main>


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

	<?php $this->load->view('templates/scripts_pmb'); ?>


</body>
</html>