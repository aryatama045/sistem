
<div class="row ">
    <div class="col-12" >
        <h1>NO. DOK - <b><?= $headerdok['no_dok_tdk_masuk']; ?> </b></h1>
        <div class="top-right-button-container">
            <?php if($this->session->userdata('nama_login') === $verifikasi['nip']) { ?>
                <div class="btn-group">
                    <a class="btn btn-outline-primary btn-lg" href="<?= base_url('leaves/batal') ?>" >
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            <?php }else{?>
                <div class="btn-group">
                    <a class="btn btn-outline-primary btn-lg" href="<?= base_url('dashboard') ?>" >
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            <?php } ?>
        </div>
        <br>
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

        <div class="separator mb-4"></div>

    </div>
</div>




<div class="row">
    <!-- Karyawan dan Lampiran -->
    <div class="col-12 col-lg-4 col-xl-4 col-left">
        <div class="mb-4" style=" position: -webkit-sticky;position: sticky;top: 6rem;">
            <!-- Detail Karyawan -->
            <div class="card mb-4" >
                <div class="card-body">
                    <h4 class="font-weight-bold">Detail Karyawan</h4> <hr>
                    <!-- <div class="d-flex flex-row mb-3">
                        <div class="pt-2 pr-2 pb-2">
                            <p class="list-item-heading font-weight-bold">
                                <?= $detailK['nip_karyawan'] ?> <br> <?= $detailK['nama_lengkap'] ?></p>
                        </div>
                    </div> -->
                    <p class="text-muted mb-1"> Nip</p>
                    <p class="mb-3"> <b><?= $detailK['nip_karyawan'] ?></b> </p>

                    <p class="text-muted mb-1"> Nama</p>
                    <p class="mb-3"><b><?= $detailK['nama_lengkap'] ?></b>  </p>

                    <p class="text-muted mb-1"> Divisi</p>
                    <p class="mb-3"> <?= $detailK['k_d'] ?> - <?= $detailK['n_d'] ?></p>

                    <p class="text-muted mb-1"> Jabatan</p>
                    <p class="mb-3"> <?= $detailK['k_j'] ?> - <?= $detailK['n_j'] ?></p>

                </div>
            </div>

            <!-- Lampiran -->
            <?php if($headerdok['jenis']=='CUTI DISPENSASI' || $headerdok['jenis']=='IJIN') { ?>
            <div class="card mb-4 ">
                <div class="card-body">
                    <h4 class="font-weight-bold">Lampiran</h4> <div class="separator mb-4"></div>
                    <div class="row social-image-row gallery">
                        <div class="col-6">
                            <a data-fancybox="gallery" data-src="<?php echo base_url('upload/ijin/'.$lampiran['file_1']) ?>">
                                <img class="img-fluid border-radius"
                                    src="<?php echo base_url('upload/ijin/'.$lampiran['file_1']) ?>" />
                            </a>
                        </div>
                        <div class="col-6">
                            <a data-fancybox="gallery" data-src="<?php echo base_url('upload/ijin/'.$lampiran['file_2']) ?>">
                                <img class="img-fluid border-radius"
                                    src="<?php echo base_url('upload/ijin/'.$lampiran['file_2']) ?>" />
                            </a>
                        </div>
                        <div class="col-6">
                            <a data-fancybox="gallery" data-src="<?php echo base_url('upload/ijin/'.$lampiran['file_3']) ?>">
                                <img class="img-fluid border-radius"
                                    src="<?php echo base_url('upload/ijin/'.$lampiran['file_3']) ?>" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>



    <!-- Detail Dokumen -->
    <div class="col-12 col-lg-8 col-xl-8 col-right">
        <div class="card">
            <div class="card-body">

            <form id="approve_detail" role="form" action="<?php base_url('leaves/batal/detail/'.$headerdok['no_dok_tdk_masuk']) ?>" method="post" class="form-horizontal">

                <!-- Dokumen -->
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="font-weight-bold">Detail Dokumen</h4>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th><p class="text-muted text-small">No. Dok</p></th>
                                    <td><p class="font-weight-bold "><?= $headerdok['no_dok_tdk_masuk'] ?></p></td>
                                </tr>
                                <tr>
                                    <th><p class="text-muted text-small">Tgl. Dok</p></th>
                                    <td><p class="font-weight-bold "><?= date('d-m-Y', strtotime($headerdok['tgl_dok_tdk_masuk'])) ?></p></td>
                                </tr>
                                <tr>
                                    <th><p class="text-muted text-small">Jenis</p></th>
                                    <td><p class="font-weight-bold "><?= $headerdok['jenis'] ?></p></td>
                                </tr>
                                <tr>
                                    <th><p class="text-muted text-small">Keterangan</p></th>
                                    <td><p class="font-weight-bold "><?= $headerdok['keterangan'] ?></p></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div> <hr>

                <!-- Detail Tanggal -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h4 class="font-weight-bold">Detail Tanggal <br>
                            <small><p class="font-weight-medium mt-2"> <b>Jumlah Pengajuan : <?= $jumlah_hari; ?> </b></p></small>
                        </h4> <hr>

                        <div class="card">
                            <div class="card-body">
                                <div class="scroll dashboard-list-with-user mb-2">

                                    <?php $no=0; foreach ($detaildok as $dv) { $no++; ?>
                                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                            <p class="font-weight-medium mb-0"> <?= $no.'. )'; ?></p>
                                            <div class="pl-3">
                                                    <p class="font-weight-medium mb-0"><b> <?= date('d-m-Y', strtotime($dv['tgl_tdk_masuk'])) ?> /

                                                    <?php if($headerdok['jenis']=='CUTI PENGGANTI') {?>
                                                        <?= format_indo(date('D', strtotime($dv['tgl_tdk_masuk']))); ?>
                                                    <?php }else{ ?>
                                                        <?=$dv['nama_hari']?>
                                                    <?php } ?> </b> </p>
                                                    <p class="text-muted mb-0 "> Keterangan : <?= $dv['keterangan'] ?></p>
                                            </div>

                                            <!-- <div class="d-flex justify-content-between align-items-center">
                                                <a class="" href="#" ></a>
                                                <button type="submit" class="btn btn-danger btn-lg btn-shadow">
                                                    <i class="iconsminds-folder-close"></i> Batal Dokumen</button>
                                            </div> -->
                                                
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><hr>

                <!-- Keterangan Batal -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h4 class="font-weight-bold">Keterangan Batal</h4> <hr>
                        <textarea name="keterangan_batal" class="form-control" cols="30" rows="5"
                            placeholder="Input Keterangan Batal ..." required></textarea>
                        <input type="text" hidden name="no_dok" value="<?= $headerdok['no_dok_tdk_masuk'] ?>">
                    </div>
                </div>

                <!-- Button Approve-->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <a class="" href="#" ></a>
                            <button type="submit" class="btn btn-danger btn-lg btn-shadow">
                                <i class="iconsminds-folder-close"></i> Batal Dokumen</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>




