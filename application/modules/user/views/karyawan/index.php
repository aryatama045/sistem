<style>
.input-group > .select2-container--bootstrap4 {
    width: auto !important;
    flex: 1 1 auto !important;
}

.input-group > .select2-container--bootstrap4 .select2-selection--single {
    height: 100% !important;
    line-height: inherit !important;
}
</style>


<div class="row">
		<div class="col-12">
			<h1><?= $page_title ?></h1>
			<div class="separator"></div>
			<br>
		</div>
</div>

	<!-- <div id="messages"></div> -->
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
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group row ">
                                <label class="col-sm-4 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input placeholder="Search by nip" id="nip" name="nip" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-sm-4 col-form-label">NAMA LENGKAP</label>
                                <div class="col-sm-8">
                                    <input placeholder="Search by nama lengkap" id="nama_lengkap" name="nama_lengkap" type="text" class="form-control" >
                                </div>
                            </div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA DIVISI</label>
								<div class="col-sm-8">
									<select class="form-control" name="nm_divisi" id="nm_divisi">
										<option value="">--PILIH DIVISI--</option>
										<?php foreach($nm_divisi as $d) : ?>
										<option value="<?php echo $d->divisi_id ?>"><?php echo $d->nama_divisi ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA DEPARTEMENT</label>
								<div class="col-sm-8">
								<select class="form-control" name="nm_departement" id="nm_departement">
									<option value="">--PILIH SEMUA DEPARTMENT--</option>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA STORE</label>
								<div class="col-sm-8">
								<select class="form-control" name="nm_store" id="nm_store">
									<option value="">--PILIH SEMUA STORE--</option>
								</select>
								</div>
							</div>
                        </div>
                    </div>
					<hr>
					<table id="tableKaryawan" class="table table-bordered data-table">
						<thead>
							<tr>
								<th>NIP</th>
								<th>NAMA LENGKAP</th>
                                <th>DIVISI</th>
                                <th>DEPT</th>
                                <th>STORE</th>
								<th>OPTION</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>


<!-- Modal -->
<div class="modal fade" id="editModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?= base_url('user/approve/edit_action') ?>" method="post">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row" hidden>
					<label class="col-sm-4">Nip</label>
					<div class="col-sm-8">
						<input name="biodata_karyawan" type="text" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4">EDIT PIC</label>
					<div class="col-sm-8">
						<select class="form-control select2-single" data-width="100%" name="pic_approve"  required>
							<option class="select-app"></option>
							<?php foreach($pic_approve as $d) {
								if(!empty($d->nama_lengkap)){ ?>
									<option value="<?= $d->biodata_id ?>"><?= $d->nip ?> - <?= $d->nama_lengkap ?></option>
							<?php } } ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4">URUTAN APP</label>
					<div class="col-sm-8">
						<input name="app_urutan" type="text" class="form-control" >
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary"
					data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="removeModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?= base_url('user/approve/remove_action') ?>" method="post">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-group row" hidden >
					<div class="col-sm-8">
						<input name="id_karyawan" type="text" class="form-control" readonly>
						<input name="id_karyawan_pic" type="text" class="form-control" readonly>
						<input name="pic_urutan" type="text" class="form-control" readonly>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-12">
						<p> Are you sure Remove !!</p>
						<p class="data-content"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary"
					data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger"> Remove</button>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('karyawan', 'index', 'js');  ?>