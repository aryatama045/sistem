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

</style>

<div class="row">
    <div class="col-12">
        <h1>NO. DOC : <?= $header_data['header']['no_dok_cuti'] ?></span></h1>
        <div class="top-right-button-container">
            <div class="btn-group">
                <button onclick="history.go(-1); return false;" class="btn btn-primary mb-0"> Kembali</button>
            </div>
        </div>
        <div class="separator"></div><br>
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


<div class="row justify-content-center">
    <?php $status_hrd['no_dok'] == NULL && empty($status_hrd['no_dok']) && $header_data['header']['ket_status_absensi'] =='SAKIT SURAT KETERANGAN'?
    $class='col-12 col-lg-7 col-xl-7 col-left':
    $class='col-12 col-md-7 col-lg-7 col-xl-7 col-left'; ?>
    <div class="<?= $class; ?>">

        <div class="card mb-4">
            <div class="card-body">

                <p class="text-muted mb-2">No. Doc </p>
                <p class="mb-3 list-item-heading" >
                    <input type="text" class="form-control" name="no_doc" value="<?= $header_data['header']['no_dok_cuti'] ?>" readonly>
                </p>

                <p class="text-muted mb-2">Tgl. Dokumen</p>
                <p class="mb-3 list-item-heading" >
                    <input type="text" class="form-control" readonly placeholder="<?= $header_data['header']['tgl_dok_cuti'] ?>">
                </p>

                <p class="text-muted mb-2">Tgl. Mulai Cuti</p>
                <p class="mb-3 list-item-heading" >
                    <input type="text" class="form-control" readonly placeholder="<?= $header_data['header']['tgl_mulai_cuti'] ?>">
                </p>

                <p class="text-muted mb-2">Jenis Cuti</p>
                <p class="mb-3 list-item-heading" >
                    <input type="text" class="form-control" name="status_cuti" value="<?= $header_data['header']['jenis_cuti'] ?>" readonly>
                </p>

                <p class="text-muted mb-2">Keterangan</p>
                <p class="mb-4 list-item-heading" >
                    <textarea name="keterangan" readonly name="keterangan_header" class="form-control"><?= $header_data['header']['keterangan'] ?></textarea>
                </p>

                <?php if ($header_data['header']['tj_sukacita']!="00.0"){ ?>
                    <p class="text-muted mb-2">TJ. Sukacita</p>
                    <p class="mb-4 list-item-heading" >
                        <input type="text" class="form-control" readonly value="<?= $header_data['header']['tj_sukacita'] ?>">
                    </p>
                <?php } else { ?>
                    <p class="text-muted mb-2">TJ. Sukacita</p>
                    <p class="mb-4 list-item-heading" >
                        <input type="text" class="form-control" readonly value="<?= $header_data['header']['tj_dukacita'] ?>">
                    </p>
                <?php } ?>

                <h5 class="pt-4"> Detail </h5>
                <table id="TableCutiList" class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Tgl Cuti</th>
                            <th>Keterangan </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($header_data['detail_item'])):?>
                        <?php foreach ($header_data['detail_item'] as $key => $val) : ?>
                        <tr>

                            <td>
                                <?= $val['tgl_cuti'] ?>
                                <div hidden class="input-group ">
                                    <span class="input-group-text input-group-append input-group-addon ">
                                        <i class="simple-icon-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control " name="tgl_cuti[]" value="<?= $val['tgl_cuti'] ?>" readonly>
                                </div>
                            </td>

                            <td>
                                <?= $val['keterangan'] ?>
                                <input hidden id="keterangan" class="form-control" readonly name="keterangan_cuti[]" value="<?= $val['keterangan'] ?>" type="text" /></td>
                        </tr>
                        <?php endforeach;?>
                    <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5>Pic Approval</h5>
                <table id="TableCuti" class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tgl. Approval</th>
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
                            <tr>
                                <td><?php if(!empty($status_hrd['pic_koreksi'])){ ?>
                                    <?= $status_hrd['nama'] ?>
                                <?php }else{ ?>VERIFIKASI HRD <?php } ?></td>
                                <td><?= $status_hrd['tgl_koreksi'] ?></td>
                                <td><?= $status_hrd['tgl_reject'] ?></td>
                                <td><?= $status_hrd['alasan_reject'] ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 ><span>Lampiran</span></h5>
                <hr>
                <div class="row social-image-row gallery">
                    <div class="col-4">
                        <h5><span class="small"> Lampiran 1</span></h5>
                        <a data-fancybox="gallery" data-src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_1']) ?>" >
                            <img width="100%" src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_1']) ?>" />
                        </a>
                    </div>
                    <div class="col-4">
                        <h5><span class="small"> Lampiran 2</span></h5>
                        <a data-fancybox="gallery" data-src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_2']) ?>" >
                            <img width="100%" src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_2']) ?>" />
                        </a>
                    </div>
                    <div class="col-4">
                        <h5><span class="small"> Lampiran 3</span></h5>
                        <a data-fancybox="gallery" data-src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_3']) ?>" >
                            <img width="100%" src="<?php echo base_url('upload/ijin/'.$header_data['header']['file_3']) ?>" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-12 col-lg-5 col-xl-5 col-right">
        <!-- d-none d-lg-block -->
        <div class="card mb-4 ">
            <div class="card-body">
                <h5 class=""><span>Re-Upload Lampiran </span></h5>
                <small> * Bila foto tidak dapat terbaca jelas / blur silahkan re-upload ulang
                        <br> * Re-Upload hanya bisa selama belum diverifikasi hrd
                        <!-- <br> ** Proses upload tunggu hingga muncul tanda ceklis ( <i class="fa fa-check"></i> ) -->
                </small>
                <hr>
                <div class="row ">
                    <div class="col-12 col-xl-12 drop-area-container">
                        <form action="<?= base_url('leaves/cuti_dispensasi/reupload_image')?>" method="post" enctype="multipart/form-data">
                            <input type="text" hidden class="form-control" name="id_doc" value="<?= $header_data['header']['cuti_dispensasi_h_id'] ?>" readonly>
                            <input type="text" hidden class="form-control" name="no_docs" value="<?= $header_data['header']['no_dok_cuti'] ?>" readonly>
                            <div class="card drop-area">
                                <div class="card-body">
                                    <h5><span> Lampiran 1</span></h5>
                                    <div class="center">
                                        <div class="form-input">
                                            <div class="preview1">
                                                <img id="file-ip-1-preview">
                                            </div>
                                            <label class="btn btn-primary" for="file-ip-1">Select Image</label>
                                            <input type="file" name="lampiran1" id="file-ip-1" accept="image/*" onchange="showPreview(event);">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card drop-area mt-4">
                                <div class="card-body">
                                    <h5><span> Lampiran 2</span></h5>
                                    <div class="center">
                                        <div class="form-input">
                                            <div class="preview2">
                                                <img id="file-ip-2-preview">
                                            </div>
                                            <label class="btn btn-primary" for="file-ip-2">Select Image</label>
                                            <input type="file" name="lampiran2" id="file-ip-2" accept="image/*" onchange="showPreview2(event);">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card drop-area mt-4">
                                <div class="card-body">
                                    <h5><span> Lampiran 3</span></h5>
                                    <div class="center">
                                        <div class="form-input">
                                            <div class="preview3">
                                                <img id="file-ip-3-preview">
                                            </div>
                                            <label class="btn btn-primary" for="file-ip-3">Select Image</label>
                                            <input type="file" name="lampiran3" id="file-ip-3" accept="image/*" onchange="showPreview3(event);">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <div class="col-12 col-right">
                                    <button type="submit" class="btn btn-primary mb-0">
                                    Re-Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>
<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<script>

    var manageTable;

    $(document).ready(function() {

        // initialize the datatable
        manageTable = $('#TableCutiList').DataTable({
            scrollY: '50vh',
            scrollCollapse: true,
            paging: false,
        });
        $("#TableCutiList_filter").css("display", "none");

    });

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




