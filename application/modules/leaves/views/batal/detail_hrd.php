<link rel="stylesheet" href="<?= base_url('theme/default/') ?>css/vendor/component-custom-switch.min.css" />

<div class="row ">
    <div class="col-12" >
        <!-- <h1>NO. DOK - <b><?= $headerdok['no_dok_tdk_masuk']; ?> </b></h1> -->
        <div class="alert alert-danger alert-dismissible" role="alert">
            <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
            <p><b>Silahkan Cek Kembali Apakah Sudah Yakin !!</b> untuk pembatalan dokumen</p>
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
                <h4><b>NO DOK - <?= $headerdok['no_dok_tdk_masuk']; ?> </b></h4>
                <hr>
                    <!-- <div class="d-flex flex-row mb-3">
                        <div class="pt-2 pr-2 pb-2">
                            <p class="list-item-heading font-weight-bold">
                                <?= $detailK['nip_karyawan'] ?> <br> <?= $detailK['nama_lengkap'] ?></p>
                        </div>
                    </div> -->

                    <!-- <div class="d-flex flex-row mb-3">
                        <a class="d-block position-relative" data-fancybox="gallery" data-src="http://localhost/hrd_cuti/theme/default/img/profiles/l-1.jpg">
                            <img src="http://localhost/hrd_cuti/theme/default/img/profiles/l-1.jpg" class="img-thumbnail img-fluid border-radius border-0  mb-4 list-thumbnail mx-auto">
                        </a>

                        <div class="pl-3 pt-2 pr-2 pb-2">
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
                                <?php if($headerdok['jenis'] != 'CUTI PENGGANTI'){ ?>
                                <tr>
                                    <th><p class="text-muted text-small">Status</p></th>
                                    <td><p class="font-weight-bold "><?= $headerdok['status_absensi'] ?></p></td>
                                </tr>
                                <?php } ?>

                                <?php if($headerdok['jenis'] == 'CUTI'){ ?>
                                <tr>
                                    <th><p class="text-muted text-small">Sumber Potong Cuti</p></th>
                                    <td><p class="font-weight-bold "><?= $headerdok['sumber_potong'] ?></p></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <th><p class="text-muted text-small">Keterangan</p></th>
                                    <td><p class="font-weight-bold "><?= $headerdok['keterangan'] ?></p></td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div> <hr>

                <!-- Approval -->
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h4 class="font-weight-bold">Approval</h4>
                        <hr>
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>App</th>
                                    <th>Tgl. App</th>
                                    <th>Tgl. Reject</th>
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
                        <p class="font-weight-bold mt-2">Status App:
                            <?php if($headerdok['status_dokumen']=='C'){ ?>
                            <span class="badge badge-pill badge-success mb-1">APPROVE</span>
                            <?php }elseif($headerdok['status_dokumen']=='P'){ ?>
                            <span class="badge badge-pill badge-secondary mb-1">PROSES</span>
                            <?php }elseif($headerdok['status_dokumen']=='R'){?>
                            <span class="badge badge-pill badge-danger mb-1">REJECT</span>
                            <?php }else{ ?>
                            <span class="badge badge-pill badge-info mb-1">OPEN</span>
                            <?php } ?>

                        </p>
                    </div>
                </div><hr>

                <!-- Detail Tanggal -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-1">
                            <h1 class="font-weight-bold">
                                <p class="list-item-heading mb-0 font-weight-bold" ><b>Detail Tanggal</b></p>
                                <small ><p class="font-weight-medium"> Jumlah Pengajuan : <b><?= $jumlah_hari; ?> </b></p></small>
                            </h1>

                            <?php if($headerdok['jenis']=='CUTI' || $headerdok['jenis']=='IJIN' && $headerdok['status_dokumen']=='C') { ?>
                            <div class="top-right-button-container">
                                <div class="btn-group">
                                    <div class="btn btn-outline-primary btn-sm check-button" >
                                        <label class="custom-checkbox mb-0">
                                            <input type="checkbox" class="form-check-input" id="checkAll" checked>
                                            <span class="label pr-2">Check All </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="separator"></div>
                            <br>


                        </div>

                        <!-- <div class="separator mt-4 mb-4"></div> -->

                        <?php if($headerdok['jenis']=='CUTI' || $headerdok['jenis']=='IJIN' && $headerdok['status_dokumen']=='C') { ?>

                        <div class="list disable-text-selection mt-4 mb-4" data-check-all="checkAll">

                            <?php $no=0; foreach ($detaildok as $dv) { $no++; ?>
                            <div class="card d-flex flex-row mb-3">
                                <div class="d-flex flex-grow-1 min-width-zero">
                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                        <p class="list-item-heading mb-0 truncate w-40 w-xs-100 mt-0" >
                                            <b><span class="align-middle d-inline-block">
                                                <?php if($headerdok['jenis']=='CUTI PENGGANTI') {?>
                                                    <?= format_indo(date('D', strtotime($dv['tgl_tdk_masuk']))); ?>
                                                <?php }else{ ?>
                                                    <?=$dv['nama_hari']?>
                                                <?php } ?> / <?= date('d-m-Y', strtotime($dv['tgl_tdk_masuk'])) ?> </b></span>
                                        </p>
                                        <p class="mb-0 text-muted text-small w-30 w-xs-100">KET : <?= $dv['keterangan'] ?></p>
                                        <?php if($dv['is_batal']=='1') { ?>
                                            <div class="w-15 w-xs-100">
                                                <span class="badge badge-pill badge-danger">BATAL</span>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="w-15 w-xs-100">
                                                <span class="badge badge-pill badge-secondary">ON HOLD</span>
                                            </div>
                                        <?php } ?>

                                    </div>
                                    <?php if($dv['is_batal']!='1') { ?>
                                        <label class="custom-control custom-checkbox mb-0 align-self-center mr-4 mb-1">
                                            <input type="checkbox" name="tgl_cuti[]" value="<?= $dv['tgl_tdk_masuk'] ?>" class="custom-control-input" checked>
                                            <span class="custom-control-label">&nbsp; </span>
                                        </label>
                                    <?php }else{ ?>
                                        <label class="custom-control custom-checkbox mb-0 align-self-center mr-4 mb-1">
                                        </label>

                                    <?php } ?>

                                </div>
                            </div>
                            <?php } ?>

                        </div>

                        <?php }else{ ?>

                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="scroll dashboard-list-with-user mb-2">

                                    <?php $no=0; foreach ($detaildok as $dv) { $no++; ?>
                                        <div class="d-flex flex-row mb-3 pb-3 border-bottom">
                                            <p class="font-weight-medium mb-0"> <?= $no.'. )'; ?></p>
                                            <div >
                                                <p class="font-weight-medium pl-3 mb-0">
                                                    <b> <?= date('d-m-Y', strtotime($dv['tgl_tdk_masuk'])) ?> /

                                                    <?php if($headerdok['jenis']=='CUTI PENGGANTI') {?>
                                                        <?= format_indo(date('D', strtotime($dv['tgl_tdk_masuk']))); ?>
                                                    <?php }else{ ?>
                                                        <?=$dv['nama_hari']?>
                                                    <?php } ?> </b>
                                                </p>
                                                <p class="text-muted pl-3 mb-0 "> Keterangan : <?= $dv['keterangan'] ?></p>
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

                        <?php } ?>

                    </div>
                </div>
                <div class="separator mt-5 mb-2"></div>

                <!-- Keterangan Batal -->
                <div class="row ">
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
                            <?php if($this->session->userdata('nama_login') === $verifikasi['nip']) { ?>
                                <a class="btn btn-primary btn-lg btn-shadow" href="<?= base_url('leaves/batal') ?>" >
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            <?php }else{?>
                                <a class="btn btn-primary btn-lg btn-shadow" href="<?= base_url('dashboard') ?>" >
                                    <i class="fa fa-arrow-left"></i> Kembali
                                </a>
                            <?php } ?>
                            <button type="submit" class="btn  <?= ($headerdok['status_dokumen']=='C')?'btn-danger':'btn-warning'; ?>  btn-lg btn-shadow">
                                <i class="iconsminds-folder-close"></i> Batal <?= ($headerdok['status_dokumen']=='C')?'Posting':'Proses'; ?> </button>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>




