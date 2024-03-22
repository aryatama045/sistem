
<div class="row">
	<div class="col-12">
		<div class="card mb-2">
			<div class="card-body">

				<h5 class="mb-4"><i class="iconsminds-mail-3"></i>PENGAJUAN OVERTIME</h5>
                <div class="row">
                    <div class="col-lg-7">
                        <input hidden type="text" name="biodata_id" value="<?= $biodataid ?>" class="form-control"  readonly>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">NO.DOC</label>
                            <div class="col-sm-7">
                                <input type="text" name="no_dokumen" class="form-control" value="<?= $header['no_dokumen'] ?>" disabled>
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
                    </div>
                    <div class="col-lg-5">
                            <label ><h3>Data Approval</h3> </label>
							<!-- Table Approval -->
                            <div class="card-body">
                                <table class="table table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Approval</th>
                                            <th>Reject</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($urutan_data)):?>
                                    <?php $no=0; foreach ($urutan_data as $key => $val) : $no++?>
                                        <tr>
                                            <td><?= $val['nama_app'] ?></td>
                                            <td><?= $approval_data['tgl_app_'.$val['urutan_approval']] ?></td>
                                            <td><?= $approval_data['tgl_rej_'.$val['urutan_approval']] ?></td>
                                            <td><b><i><?= $approval_data['rej_komentar_'.$val['urutan_approval']] ?></i></b></td>
                                        </tr>
                                    <?php endforeach;?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div> <hr>

			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>


<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php echo $this->load->assets('overtime', 'create', 'js');  ?>

