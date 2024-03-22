<style>
	#datepicker {
		width:100px; 
		padding:0;
		height:20px;
		line-height:20px;}
	.ui-datepicker {
		/* opacity: 1; */
		/* position: absolute; */
		top: 460px !important;
		left: 380px !important;
		z-index: 4;
		/* display: block; */
		}
</style>
<link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/vendor/bootstrap-float-label.min.css" />

<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

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


				<h5 class="mb-4">PENGAJUAN CUTI</h5>
				<div class="separator mb-4"></div>
				<form role="form" action="<?php base_url('leaves/cuti/create') ?>" method="post" class="form-horizontal">
					<div class="row">
						<div class="col-lg-6">

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">NO.DOC</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" value="<?= $no_doc ?>" readonly>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-5 col-form-label">KARYAWAN</label>
								<div class="col-sm-6">
									<label class="has-float-label">
									<select class=" form-control select2-single" data-width="100%" name="nip" id="getKaryawan">
										<option value="" selected></option>
										<?php foreach($data_karyawan as $d) {
											if(!empty($d->nama_lengkap)){ ?>

												<option value="<?= $d->nip ?>"><?= $d->nip ?> - <?= $d->nama_lengkap ?></option>

										<?php } } ?>
									</select>
									<span>Select Karyawan</span>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-5 col-form-label">SUMBER POTONG CUTI</label>
								<div class="col-sm-6">
									<select class="form-control select2-single"  name="potong_cuti_dari" data-width="100%">

											<option value="NORMATIF">NORMATIF</option>
											<option value="TAMBAHAN">TAMBAHAN</option>

									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-5 col-form-label">JENIS CUTI</label>
								<div class="col-sm-6">
									<?php //echo form_dropdown($status_absensi_id, $status_absensi_id_option)?>
									<select name="jumlah_hari"  class="form-control select2-single" required>
										<option value="">-- Pilih Jenis Cuti --</option>
										<option value="0.5">CUTI 1/2 HARI</option>
										<option value="1">CUTI 1 HARI</option>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-5">KETERANGAN</div>
								<div class="col-sm-6">
										<textarea name="keterangan" class="form-control" ></textarea>
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<fieldset class="form-group">
								<div class="row">
									<label class="col-form-label col-sm-7 pt-0">NORMATIF <br>( <?= date('Y') ?> )</label>
									<div class="col-sm-5">
										<label class="form-check-label">
											<span id="sisa_normatif"></span>
										</label>
									</div>
								</div>

								<?php if($normatifsny) { ?>
								<div class="row">
									<label class="col-form-label col-sm-7 pt-0">NORMATIF ( <?= date('Y')+1 ?> )</label>
									<div class="col-sm-4">
										<label class="form-check-label">
											<?php echo $normatifsny['sisa_normatif'] ?>
											<input type="text" hidden name="sisa_normatif" value="<?php echo $normatifsny['sisa_normatif'] ?>">
											<input type="text" hidden name="mulai_berlaku_normatif" value="<?php echo $normatifsny['tgl_mulai_berlaku'] ?>">
											<input type="text" hidden name="akhir_berlaku_normatif"  value="<?php echo $normatifsny['tgl_akhir_berlaku'] ?>">
										</label>
									</div>
								</div>
								<?php } ?>


								<div class="row">
									<label class="col-form-label col-sm-7 pt-0">TAMBAHAN</label>
									<div class="col-sm-4">
										<label class="form-check-label">
										<?php if($tambahan['sisa_cuti_tambahan']=='' || $tambahan['sisa_cuti_tambahan']=='0') { ?>
												0
												<input type="text" name="sisa_tambahan" hidden value="0" />
											<?php } else {?>
												<?php echo $tambahan['sisa_cuti_tambahan'] ?>
												<input type="text" hidden name="sisa_tambahan" value="<?php echo $tambahan['sisa_cuti_tambahan'] ?>">
												<input type="text" hidden name="mulai_berlaku_tambahan" value="<?php echo $masa_ASC['tgl_mulai_berlaku'] ?>">
												<input type="text" hidden name="akhir_berlaku_tambahan"  value="<?php echo $masa_DESC['tgl_akhir_berlaku'] ?>">
											<?php } ?>
										</label>
									</div>
								</div>

							</fieldset>
						</div>
						<div class="col-lg-3">
							<?php if($masa_tambahan != null) { ?>
							<div class="form-group">
								<label class="form-check-label text-center">MASA BERLAKU CUTI TAMBAHAN</label>
								<div class="separator mb-2"></div>
								<?php foreach($masa_tambahan as $value){ ?>
									<?php echo $value['tgl_mulai_berlaku'] ?>
									Sampai
									<?php echo $value['tgl_akhir_berlaku'] ?><br>
								<?php } ?>
							</div>
							<?php } ?>
						</div>
					</div>

                    <hr>

					<div class="row mb-4">
						<div class="col-12">
							<div class="card h-100">
								<div class="card-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <h5 style="padding-bottom: 10px;display: inline-block;">Data Pengajuan Cuti</h5>

                                            <div class="top-right-button-container">
                                                <div class="btn-group">
                                                    <button type="button" name="add" class="btn btn-outline-primary btn-xs add">
                                                        <i class="fa fa-plus"></i> Add
                                                    </button>
                                                </div>
                                            </div>
                                            <br>
                                            <hr>
                                        </div>
                                    </div>

                                    <div class="item_table" id="item_table">

                                        <div class="form-group mb-3" id="dtTgl">
                                            <div class="input-group typeahead-container" >
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-append input-group-addon typeahead"><i class="simple-icon-calendar"></i></span>
                                                    <input type='text' class="form-control" id='dtfirst' name="tgl_tdk_masuk[]" placeholder="Pilih Tanggal"  />

                                                    <div class="input-group-append">
                                                        <button type="button" name="add" class="btn btn-primary default add">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <hr>

								</div>
							</div>
						</div>
					</div>

					<hr>

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
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('hrd_cuti', 'creates', 'js');  ?>
