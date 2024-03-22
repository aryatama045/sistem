
<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

				<h5 class="mb-4"><i class="iconsminds-mail-3"></i>REJECT PENGAJUAN OVERTIME</h5>
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
				<form action="<?= base_url('leaves/overtime/reject_action') ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">NO.DOC</label>
                                <div class="col-sm-7">
                                    <input type="text" name="no_dokumen" class="form-control" value="<?= $header['no_dokumen'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">NIP</label>
                                <div class="col-sm-7">
                                    <input type="text" name="nip" class="form-control" value="<?= $header['nip'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Tgl. Lembur</label>
                                <div class="col-sm-7">
                                <input type="text" id="tgl_lembur" name="tgl_lembur" class="form-control" value="<?= $header['tgl_lembur'] ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Jam IN</label>
                                <div class="col-sm-7">
                                    <input type="text" value="<?= $header['jam_in'] ?>" name="jam_in" class="form-control" disabled >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">Jam OUT</label>
                                <div class="col-sm-7">
                                    <input type="text"  value="<?= $header['jam_out'] ?>" name="jam_out" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">KETERANGAN</div>
                                <div class="col-sm-7">
                                        <textarea  name="keterangan" value="<?= $header['keterangan'] ?>" class="form-control" disabled><?= $header['keterangan'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">KETERANGAN REJECT</div>
                                <div class="col-sm-7">
                                        <textarea  name="keterangan_rej" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div> <hr>
                    <div   div class="row">
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
<!-- <?php //echo $this->load->assets('overtime', 'create', 'js');  ?> -->

