


<style>
    input#session-date{
    position:relative;
    overflow:hidden;
    }
    input#session-date::-webkit-calendar-picker-indicator{
    display:block;
    top:0;
    left:0;
    background: #0000;
    position:absolute;
    transform: scale(60)
    }

	input#session-date2{
    position:relative;
    overflow:hidden;
    }
    input#session-date2::-webkit-calendar-picker-indicator{
    display:block;
    top:0;
    left:0;
    background: #0000;
    position:absolute;
    transform: scale(60)
    }

    input#tgl_lembur{
    position:relative;
    overflow:hidden;
    }
    input#tgl_lembur::-webkit-calendar-picker-indicator{
    display:block;
    top:0;
    left:0;
    background: #0000;
    position:absolute;
    transform: scale(60)
    }
</style>
<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

				<h5 class="mb-4"><i class="iconsminds-mail-3"></i>
				PENGAJUAN OVERTIME </h5>
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
				<form action="<?= base_url('leaves/overtime/cek') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
					<div class="row">
						<div class="col-lg-7">
							<input hidden type="text" name="biodata_id" value="<?= $biodataid ?>" class="form-control"  readonly>

							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NO.DOC</label>
								<div class="col-sm-7">
									<input type="text" name="no_dokumen" class="form-control" value="<?= $no_doc ?>" readonly>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-4 col-form-label">NIP</label>
								<div class="col-sm-7">
									<input type="text" name="nip" class="form-control" value="<?= $nip ?>" readonly>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-4 col-form-label">Tgl. Lembur</label>
								<div class="col-sm-7">
									<div class="input-group">
										<span class="input-group-text input-group-append input-group-addon"><i class="simple-icon-calendar"></i></span>
										<input type="text" id="tgl_lembur" name="tgl_lembur" class="form-control" value="<?= set_value('tgl_lembur'); ?>" placeholder="Pilih Tanggal Masuk">
									</div>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-4 col-form-label">Jam IN</label>
								<div class="col-sm-7">
									<?php if($this->session->userdata('nama_login') == '21020010'){ ?>
										<input type="text" id="session-date" value="08:00:00" name="jam_in" class="form-control" >
									<?php } else { ?>
										<input type="text" id="session-date" value="<?php echo date('H:i:s'); ?>" name="jam_in" class="form-control" >
									<?php } ?>
								</div>
							</div>
                            <div class="form-group row">
								<label class="col-sm-4 col-form-label">Jam OUT</label>
								<div class="col-sm-7">
									<input type="text"  id="session-date2" value="<?php echo date('H:i:s'); ?>" name="jam_out" class="form-control">
								</div>
							</div>
							<?php if($this->session->userdata('nama_login') == '21020010'){ ?>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status</label>
								<div class="col-sm-7">
									<select name="status"  class="select form-control">
										<option value=""> -- Status --</option>
										<option value="HD">HD</option>
										<option value="CG">CG</option>
									</select>
								</div>
							</div>

							<?php } ?>
							<div class="form-group row">
								<div class="col-sm-4">KETERANGAN</div>
								<div class="col-sm-7">
										<textarea name="keterangan" value="<?= set_value('keterangan'); ?>" class="form-control"></textarea>
								</div>
							</div>
						</div>
                        <div class="col-lg-5">
							<label ><h3>Data Absensi</h3> </label>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JAM MASUK : </label>
								<div class="col-sm-6">
									<div id="jam1"></div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JAM KELUAR : </label>
								<div class="col-sm-6">
									<div id="jam2"></div>
								</div>
							</div>
                        </div>
					</div> <hr>
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


<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>


<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('overtime', 'create', 'js');  ?>

