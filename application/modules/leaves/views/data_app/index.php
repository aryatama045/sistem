<style>
		.dataTables_scrollHeadInner{
			width : 100% !important
		}

	.input-group > .select2-container--bootstrap4 {
		width: auto !important;
		flex: 1 1 auto !important;
	}

	.input-group > .select2-container--bootstrap4 .select2-selection--single {
		height: 100% !important;
		line-height: inherit !important;
	}
</style>

<link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/vendor/bootstrap-float-label.min.css" />


	
	<div class="row">
		<div class="col-12">
			<h1>Data Approval</h1>
			<div class="separator"></div>
			<br>
		</div>
	</div>

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
				<div class="card-header">
					<ul class="nav nav-tabs card-header-tabs " role="tablist">

						<!-- Detail -->
						<li class="nav-item font-weight-bold">
							<a class="nav-link active" id="pic-tab" data-toggle="tab" href="#pic" role="tab"
								aria-controls="pic" aria-selected="true">Data Pic Approval</a>
						</li>

						<!-- app cuti -->
						<li class="nav-item font-weight-bold">
							<a class="nav-link" id="appcuti-tab" data-toggle="tab" href="#appcuti" role="tab"
								aria-controls="appcuti" aria-selected="true">List App Cuti</a>
						</li>

						<!-- app cp -->
						<li class="nav-item font-weight-bold">
							<a class="nav-link" id="appcp-tab" data-toggle="tab" href="#appcp" role="tab"
								aria-controls="appcp" aria-selected="true">List App CP</a>
						</li>

					</ul>
				</div>
				<hr>

				<div class="card-body">
                    <div class="tab-content">

						<!-- PIC Approval -->
						<div class="tab-pane fade show active" id="pic" role="tabpanel" aria-labelledby="pic-tab">
							<div class="top-right-button-container">
								<div class="btn-group">
									<a class="btn btn-outline-primary btn-md" href="#" data-toggle="modal" data-target="#tambahPic">
										Tambah PIC
									</a>

								</div>
							</div>
							<div class="card-body">
							<table id="tablePic" class="table table-bordered data-table">
								<thead>
									<tr>
										<th>NIP </th>
										<th>NAMA LENGKAP</th>
										<th>DEPT</th>
										<th>STORE</th>
									</tr>
								</thead>
							</table>
							</div>

						</div>


						<!-- Karyawan Approval cuti-->
						<div class="tab-pane fade" id="appcuti" role="tabpanel" aria-labelledby="appcuti-tab">
							<div class="card-body">
								<div class="top-right-button-container">
									<div class="btn-group">
										<a class="btn btn-outline-primary btn-md" href="<?= base_url('user/approve') ?>" >
											Tambah App Cuti
										</a>
									</div>
								</div>

									<div class="row">
										<div class="col-md-7">
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">NAMA KARYAWAN</label>
												<div class="col-sm-8">
													<select class=" form-control select2-single" width="100%" name="nip_cuti" id="nip_cuti">
														<option value="">--PILIH KARYAWAN--</option>
														<?php foreach($data_karyawan as $d) {
															if(!empty($d->nama_lengkap)){ ?>
																<option value="<?= $d->nip ?>"><?= $d->nip ?> - <?= $d->nama_lengkap ?></option>
														<?php } } ?>
													</select>
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

										</div>
									</div>
								<table id="tableAbsen" class="table table-bordered data-table">
									<thead>
										<tr>
											<th>NIP </th>
											<th>NAMA LENGKAP</th>
											<th>PIC APPROVAL</th>
											<th>#APPROVAL</th>
											<th>CABANG</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>

						<!-- Karyawan Approval cp-->
						<div class="tab-pane fade" id="appcp" role="tabpanel" aria-labelledby="appcp-tab">
							<div class="card-body">
								<div class="top-right-button-container">
									<div class="btn-group">
										<a class="btn btn-outline-primary btn-md" href="<?= base_url('user/approve/cp') ?>" >
											Tambah App CP
										</a>
									</div>
								</div>

								<div class="row">
									<div class="col-md-7">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">NAMA KARYAWAN</label>
											<div class="col-sm-8">
												<select class=" form-control select2-single" width="100%" name="nip_user" id="nip_user">
													<option value="">--PILIH KARYAWAN--</option>
													<?php foreach($data_karyawan as $d) {
														if(!empty($d->nama_lengkap)){ ?>
															<option value="<?= $d->nip ?>"><?= $d->nip ?> - <?= $d->nama_lengkap ?></option>
													<?php } } ?>
												</select>
											</div>
										</div>

									</div>
								</div>
								<table id="tableAppcp" class="table table-bordered data-table">
									<thead>
										<tr>
											<th>NIP USER</th>
											<th>NAMA LENGKAP</th>
											<th>NIP APPROVAL</th>
											<th>PIC APPROVAL</th>
											<th>#URUTAN</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<div class="modal fade" id="tambahPic" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tambahPicLabel">Tambah Pic</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form class="form-side" action="<?= base_url('user/approve/tambah_pic') ?>" method="post">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8">
						<label class="form-group has-float-label mb-4">
							<select class=" form-control select2-single" width="100%" name="karyawan" id="karyawan">
								<option value="">--PILIH KARYAWAN--</option>
								<?php foreach($data_karyawan as $d) {
									if(!empty($d->nama_lengkap)){ ?>

										<option value="<?= $d->biodata_id ?>"><?= $d->nip ?> - <?= $d->nama_lengkap ?></option>

								<?php } } ?>
							</select>
							<span>NAMA KARYAWAN</span>
						</label>
						<div class="row-group has-float-label">
							<input type="text" class="form-control" name="email_pic">
							<span>EMAIL</span>
						</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- <button type="button" class="btn btn-secondary"
						data-dismiss="modal">Close</button> -->
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
				</form>
			</div>
		</div>
	</div>

<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php //echo $this->load->assets('data_app', 'index', 'js');?>
<script>
	$(document).ready(function(){
			$('#nm_divisi').change(function(){ 
				var id = $('[name=nm_divisi]').val();
				// alert(id);
				$.ajax({
					url : "<?php echo site_url('leaves/data_app/get_data_departement');?>",
				method : "POST",
				data : {id: id},
				async : true,
				dataType : 'json',
				success: function(data){
					var html = '';
					var i;
					html += '<option value="">--PILIH DEPARTMENT--</option>';
					for(i=0; i<data.length; i++){
						// alert(data[i].dept_id);
						html += '<option value='+data[i].dept_id+'>'+data[i].nama_dept+'</option>';
					}
					$('#nm_departement').html(html);
				}
				});
				tableAbsen.ajax.reload();
				return false;
			});


			$('#nm_departement').change(function(){ 
				var id = $('[name=nm_departement]').val();
				var divisi_id = $('[name=nm_divisi]').val();
				// alert(divisi_id);
				$.ajax({
					url : "<?php echo site_url('leaves/data_app/get_data_store');?>",
				method : "POST",
				data : {id: id,divisi_id: divisi_id},
				async : true,
				dataType : 'json',
				success: function(data){
					var html = '';
					var i;
					html += '<option value="">--PILIH STORE--</option>';
					for(i=0; i<data.length; i++){
						// alert(data[i].dept_id);
						html += '<option value='+data[i].kd_store+'>'+data[i].nama_store+'</option>';
					}
					$('#nm_store').html(html);
				}
				});
				tableAbsen.ajax.reload();
				return false;
			});


			$('#btn-pdf-action').click(function (e) {
					var tanggal1 = $('[name=tanggal1]').val();
					var tanggal2 = $('[name=tanggal2]').val();
					// alert(tanggal2);
				$('#action').val('print');
				$("#form-print").attr('target', 'new');
				$("#form-print").submit();
				e.preventDefault();
			});

			$('#btn-excel-action').click(function (e) {
				var tanggal1 = $('[name=tanggal1]').val();
				var tanggal2 = $('[name=tanggal2]').val();
			$('#action').val('excel');
			$("#form-print").removeAttr('target');
			$("#form-print").submit();
				e.preventDefault();
			});

				// initialize the datatable 
		tableAbsen = $('#tableAbsen').DataTable({
			// 'orderCellsTop': true,
			// 'fixedHeader': true,
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'scrollX': true,
			'ajax': {
				'url': base_url + 'leaves/data_app/fetchDataAbsen',
				'type': 'POST',
							'data':function(data) {
								data.tanggal1 = $('#tanggal1').val();
								data.tanggal2 = $('#tanggal2').val();
								data.id_divisi = $('#nm_divisi').val();
								data.id_dept = $('#nm_departement').val();
								data.kd_store = $('#nm_store').val();
								data.nip_cuti = $('#nip_cuti').val();
							},
			},
			'order': [0, 'ASC'],
			'columnDefs': [{
					targets: 0,
					className: 'text-left'
				},
				{
					targets: 1,
					className: 'text-left'
				},
			]
		});
		$("#tableAbsen_filter").css("display", "none");

		$('.search-input-text').on('keyup', function(event) { // for text boxes
			var i = $(this).attr('data-column'); // getting column index
			var v = $(this).val(); // getting search input value
			var keycode = event.which;
			if (keycode == 13) {
				tableAbsen.columns(i).search(v).draw();
			}
		});
		$('.search-input-select').on('change', function() { // for select box
			var i = $(this).attr('data-column');
			var v = $(this).val();
			tableAbsen.columns(i).search(v).draw();
		});

		$('#btn-tampil').click(function(){ //button filter event click
			tableAbsen.ajax.reload();  //just reload table
		});

		$('#tanggal1').on('change', function(){ //button filter event click
			tableAbsen.ajax.reload();  //just reload table
		});

		$('#tanggal2').on('change', function(){ //button filter event click
			tableAbsen.ajax.reload();  //just reload table
		});

		$('#nm_store').on('change', function(){ //button filter event click
	        tableAbsen.ajax.reload();  //just reload table
		});
		$('#nip_cuti').on('change', function(){ //button filter event click
	        tableAbsen.ajax.reload();  //just reload table
		});
	});

	var tablePic;
	$(document).ready(function() {
		// initialize the datatable

		tablePic = $('#tablePic').DataTable({
			'processing': true,
			'serverSide': true,
			'scrollX': true,
			'ajax': {
				'url': base_url + 'leaves/data_app/fetchDataPic',
				'type': 'POST',
			},
			'order': [0, 'DESC'],
			'columnDefs': [{
					targets: 0,
					className: 'text-center'
				},
				{
					targets: 1,
					className: 'text-left'
				},
			]
		});
		$("#tablePic_filter").css("display", "none");
		$('.search-input-text').on('keyup', function(event) { // for text boxes
			var i = $(this).attr('data-column'); // getting column index
			var v = $(this).val(); // getting search input value
			var keycode = event.which;
			if (keycode == 13) {
				tablePic.columns(i).search(v).draw();
			}
		});
		$('.search-input-select').on('change', function() { // for select box
			var i = $(this).attr('data-column');
			var v = $(this).val();
			tablePic.columns(i).search(v).draw();
		});

	});

	var tableAppcp;
	$(document).ready(function() {
		// initialize the datatable

		tableAppcp = $('#tableAppcp').DataTable({
			'processing': true,
			'serverSide': true,
			'scrollX': true,
			'ajax': {
				'url': base_url + 'leaves/data_app/fetchListCP',
				'type': 'POST',
				'data': function(data) {
                data.nip = $('#nip_user').val();
            },
			},
			'order': [0, 'DESC'],
			'columnDefs': [{
					targets: 0,
					className: 'text-center'
				},
				{
					targets: 1,
					className: 'text-left'
				},
			]
		});
		$("#tableAppcp_filter").css("display", "none");
		$('.search-input-text').on('keyup', function(event) { // for text boxes
			var i = $(this).attr('data-column'); // getting column index
			var v = $(this).val(); // getting search input value
			var keycode = event.which;
			if (keycode == 13) {
				tableAppcp.columns(i).search(v).draw();
			}
		});
		$('.search-input-select').on('change', function() { // for select box
			var i = $(this).attr('data-column');
			var v = $(this).val();
			tableAppcp.columns(i).search(v).draw();
		});

		$('#nip_user').on('change', function(){ //button filter event click
	        tableAppcp.ajax.reload();  //just reload table
		});

	});

</script>


