<?php $this->load->assets('terlambat','index', 'css');  ?>
	<div class="row">
		<div class="col-12">
			<h1>Data Keterlambatan</h1>
			<div class="top-right-button-container">
				<div class="btn-group">
					<a class="btn btn-outline-primary btn-lg" href="<?= base_url('terlambat_normal/create') ?>" >
						Tambah Pengajuan
					</a>
				</div>
			</div>
			<div class="separator"></div>
			<br>
		</div>
	</div>

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

	<div class="row">
		<div class="col-12 ">
			<div class="card">
				<div class="card-body">
					<table id="manageTerlambat" class="table table-bordered data-table">
						<thead>
							<tr>
								<th>NO.DOK </th>
								<th>TGL.DOK</th>
								<th>KETERANGAN</th>
								<th>POSTING</th>
								<th class="empty">&nbsp;</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('terlambat', 'index', 'js');  ?>


