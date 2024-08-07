	<hr>

	<footer>
		<div class="footer-content">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-6">
						<p class="mb-0 text-muted">
						Copyright &copy; <?= date('Y') ?>
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

</div>

<?php $this->load->view('templates/scripts_pmb'); ?>


<script>
    $(window).on('load',function(){
        $('.loader').fadeOut(1000, function () {
            $('.content-loader').show();
        });
    })
</script>

</body>
</html>