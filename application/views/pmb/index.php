
<div class="col-lg-8 col-12">

    <section class="scroll-section">
        <div class="card">

            <?php if(validation_errors()){ ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo validation_errors(); ?>
                </div>
            <?php } ?>

            <?php if($this->session->flashdata('success')){ ?>

                <div class="text-center mt-5">
                    <h5 class="card-title">Thank You!</h5>
                    <p class="card-text text-alternate mb-4">
                        Your registration completed successfully! <br>
                        <?php echo $this->session->flashdata('success'); ?>
                    </p>
                    <!-- <button class="btn btn-icon btn-icon-start btn-primary" type="button">
                        <i data-acorn-icon="login"></i>
                        <span>Login</span>
                    </button> -->
                </div>
                <?php } elseif($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
            <?php } else { ?>


            <div class="card-header border-0 pb-0">
                <div class="mb-1 h2 title d-none d-sm-block">Form Pendaftaran </div>
                <div class="mb-1 h4 title d-none d-sm-block">Gelombang <?= $gel_daftar['kode'] ?>
                    ( <?= date_format(date_create($gel_daftar['tgl_awal']), "d M Y") ?> - <?= date_format(date_create($gel_daftar['tgl_akhir']), "d M Y") ?> ) </div>
                <div class="mb-1 h4 title d-none d-sm-block"> Jalur Seleksi Mandiri </div>
            </div>

            <div class="card-body ">
                <div class="mt-1 mb-3 h5 title d-none d-md-block">Silahkan Lengkapi data berikut:</div>
                <form action="<?= base_url('pmb/form_daftar');?>" class="" method="POST">

                    <label class="mb-3 top-label">
                        <span class="text-black">SISTEM KULIAH</span>
                        <select class="form-control" required  name="kd_jenma">
                            <option > -- Select Sistem Kuliah -- </option>
                            <?php foreach($jenma as $val){ ?>
                                <option value="<?= $val['kd_jenma'] ?>"> <?= $val['jenis_mhs'] ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label class="mb-3 top-label">
                        <span class="text-black">PROGRAM STUDI</span>
                        <select class="form-control" required  name="kd_prog" >
                            <option > -- Select Program Studi -- </option>
                            <?php foreach($prodi as $val){ ?>
                                <option value="<?= $val['kd_prog'] ?>"> <?= $val['nama_prog'] ?></option>
                            <?php } ?>
                        </select>
                    </label>

                    <label class="mb-3 top-label">
                        <input class="form-control" type="text" required name="nama" />
                        <span class="h3 title text-black">NAMA LENGKAP</span>
                    </label>
                    <label class="mb-3 top-label">
                        <input class="form-control" required name="nik" type="number" />
                        <span class="text-black">NIK</span>
                    </label>
                    <label class="mb-3 top-label">
                        <input class="form-control" required type="email" name="email" />
                        <span class="text-black">E-MAIL</span>
                    </label>
                    <label class="mb-3 top-label">
                        <input class="form-control" required name="no_hp" type="number" />
                        <span class="text-black">NO. HP</span>
                    </label>
                    <label class="mb-3 top-label">
                        <input class="form-control" required name="tahun_lulus" type="number" />
                        <span class="text-black">TAHUN LULUS</span>
                    </label>


                    <button class="btn btn-icon btn-icon-end btn-outline-primary " type="submit">
                        <span>Daftar</span>
                        <i data-acorn-icon="chevron-save"></i>
                    </button>

                </form>
            </div>

            <?php } ?>

        </div>
    </section>


</div>