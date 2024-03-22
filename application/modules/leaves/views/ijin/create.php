
<style>
    .dropzone.dz-clickable .dz-message, .dropzone.dz-clickable .dz-message *{
        transform: translateY(50%) !important;
    }

    .form-input img {
        width: 100%;
        display:none;
        margin-bottom:30px;
    }

    .center {
        height:100%;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .form-input {
        width:350px;
        padding:20px;
        background:#fff;
        box-shadow: -3px -3px 7px rgba(94, 104, 121, 0.377),
                3px 3px 7px rgba(94, 104, 121, 0.377);
    }

    .form-input input {
        display:none;
    }

	.block {
		display: block;
	}
	span.lampiran {
		display: inline-block;
	}

</style>


<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

				<h5 class="mb-4"><i class="iconsminds-mail-3"></i>
				PENGAJUAN IJIN</h5>
				<div class="separator mb-4"></div>
				<div id="messages"></div>
				<?php if($this->session->flashdata('success')): ?>
				<div class="alert alert-success " role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php elseif($this->session->flashdata('error')): ?>
				<div class="alert alert-danger rounded " role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php endif; ?>
				<?php if(validation_errors()): ?>
					<div class="alert alert-danger rounded " role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo validation_errors(); ?>
					</div>
				<?php endif; ?>
				<form role="form" action="<?= base_url('leaves/ijin/create') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">
							<input hidden type="text" name="biodata_id" value="<?= $biodataid ?>" class="form-control"  readonly>

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NO.DOC</label>
								<div class="col-sm-6">
									<input type="text" name="no_doc" class="form-control" value="<?= $no_doc ?>" readonly>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JENIS IJIN</label>
								<div class="col-sm-6">
									<?php echo form_dropdown($status_absensi_id, $status_absensi_id_option)?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">KETERANGAN</div>
								<div class="col-sm-6">
										<textarea name="keterangan" class="form-control"></textarea>
								</div>
							</div>
							<div class="form-group row" id="tampil_jam">
								<div class="col-sm-5">JAM HADIR</div>
								<div class="col-sm-6">
									<span id="jam_masuk"> </span>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="card drop-area optionlampiran">
								<div class="blocklampiran">
									<div class="card-body">
										<h5><span> Lampiran 1</span></h5>
										<div class="center">
											<div class="form-input">
												<div class="preview1">
													<img data-fancybox="gallery"  id="file-ip-1-preview">
												</div>
												<label class="btn btn-primary btn-xs btn-pill " for="file-ip-1">Select Image</label>
												<input type="file" class="form-control-file" name="file_1" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
											</div>
										</div>
									</div>
								</div>


								<div class="blocklampiran">
									<span class="addlampiran lampiran btn btn-success btn-xs btn-pill m-2 pull-right"> Add </span>
								</div>

							</div>

						</div>
					</div>

					<hr>

					<div class="row mb-4"></div>
					<div class="col-12 data-tables-hide-filter">
						<div class="card">
							<div class="card-body">
								<table id="item_table" class="table table-striped table-condensed field_wrapper">
									<thead>
										<tr>
											<th>Tgl & Jam Ijin</th>
											<th>
												<div class="form-check">
													<input class="form-check-input text-center" type="checkbox" id="chkPassport" name="kembali" >
													Kembali
												</div>
											</th>
											<th>Keterangan Ijin</th>
											<th>
														<!-- <button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i> Tambah Ijin</button> -->
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="input-group">
													<span class="input-group-text input-group-append input-group-addon"><i class="simple-icon-calendar"></i></span>	
													<input type='text' class="form-control" id='datetimepicker23' name="tgl_tdk_masuk[]" placeholder="Pilih Tanggal"  />
												</div>
											</td>
											<td>
												<div id="dvPassport" style="display: none">
													<div class="input-group ">
														<input type="datetime-local" class="form-control" name="tgl_kembali[]" value="<?= date('Y-m-d h:i:s');?>" placeholder="Pilih Tanggal">
													</div>
												</div>
												<div id="AddPassport">
													Kembali
												</div>
											</td>
											<td><input id="keterangan" class="form-control" name="keterangan_cuti[]" placeholder="Keterangan" type="text" /></td>
											<td>
													<div id="jam_hadir">
														<button id="addnew" type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i> Tambah Ijin</button>
													</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<hr>

					<div class="row">
						<div class="form-group row mb-0">
							<div class="col-sm-10">
								<button type="submit" class="btn btn-lg btn-primary mb-0">Simpan</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>


<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('ijin', 'create', 'js');  ?>

<script>
	function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview1 = document.getElementById("file-ip-1-preview");
            preview1.src = src;
            preview1.style.display = "block";
        }

    }
    function showPreview2(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview2 = document.getElementById("file-ip-2-preview");
            preview2.src = src;
            preview2.style.display = "block";
        }
    }
    function showPreview3(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview3 = document.getElementById("file-ip-3-preview");
            preview3.src = src;
            preview3.style.display = "block";
        }
    }
</script>

