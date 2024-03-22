
<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

			<div id="messages"></div>

				<?php if($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php elseif($this->session->flashdata('error')): ?>
					<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php endif; ?>
					<?php if(validation_errors()): ?>
						<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<?php echo validation_errors(); ?>
						</div>
				<?php endif; ?>
				<h5 class="mb-4">Ganti Password</h5>
				<div class="separator mb-4"></div>
				<form role="form" action="<?php base_url('dashboard/change_password') ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">New Password</label>
								<div class="col-sm-7">
									<input type="password" class="form-control" name="password" placeholder="New Password">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Konfirmasi Password</label>
								<div class="col-sm-7">
									<input type="password" class="form-control" name="cpassword" placeholder="Konfirmasi Password">
								</div>
							</div>
						</div>
					</div><hr>
					<div class="row">
						<div class="form-group row mb-0">
							<div class="col-sm-10">
								<button type="submit" class="btn btn-primary mb-0">Simpan</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
