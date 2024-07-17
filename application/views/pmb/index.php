

<div class="row">

    <!-- Left Sidebar Start -->
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

                    <div class="text-center mt-5 mb-5">
                        <h5 class="card-title">Thank You!</h5>
                        <p class="card-text text-alternate mb-4">
                            Your registration completed successfully! <br>
                            <?php echo $this->session->flashdata('success'); ?>
                        </p>
                        <a href="<?php base_url('') ?>" class="btn btn-icon btn-icon-start btn-primary" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-login undefined"><path d="M8 5 12.6464 9.64645C12.8417 9.84171 12.8417 10.1583 12.6464 10.3536L8 15M2 10H12"></path><path d="M12 18L14.5 18C15.9045 18 16.6067 18 17.1111 17.6629C17.3295 17.517 17.517 17.3295 17.6629 17.1111C18 16.6067 18 15.9045 18 14.5L18 5.5C18 4.09554 18 3.39331 17.6629 2.88886C17.517 2.67048 17.3295 2.48298 17.1111 2.33706C16.6067 2 15.9045 2 14.5 2L12 2"></path></svg>
                            <span>Login</span>
                        </a>
                    </div>
                    <?php } elseif($this->session->flashdata('error')) { ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <?php echo $this->session->flashdata('error'); ?>
                        </div>
                <?php } else { ?>

                    <!-- Form Pendaftaran -->
                    <?php if(!empty($cek_gel)){ ?>

                        <div class="card-header border-0 pb-0">
                            <div class="mb-1 h2 title d-none d-sm-block">Form Pendaftaran </div>
                            <hr>
                            <div class="mb-1 h4 title d-none d-sm-block"><b>Gelombang <?= $gel_daftar['gel'] ?>
                                ( <?= date_format(date_create($gel_daftar['tgl_awal']), "d M Y") ?> - <?= date_format(date_create($gel_daftar['tgl_akhir']), "d M Y") ?> ) </b></div>
                            <div class="mb-1 h4 title d-none d-sm-block"> Jalur Seleksi Mandiri </div>
                        </div>

                        <div class="card-body ">

                            <div class="mt-1 mb-3 h5 title d-none d-md-block"><b>Silahkan Lengkapi data berikut :</b></div>

                            <form action="<?= base_url('pmb/form_daftar');?>" class="" method="POST">
                                <input class="form-control" name="kd_ta" hidden value="<?= $kd_ta ?>"/>
                                <label class="mb-3 top-label">
                                    <span class="text-black"><strong>SISTEM KULIAH</strong></span>
                                    <select class="form-control"  required id="kd_jenma"  name="kd_jenma" >
                                        <option value="" > -- Select Sistem Kuliah -- </option>
                                        <?php foreach($jenma as $val){ ?>
                                            <option value="<?= $val['kd_jenma'] ?>"> <?= $val['jenis_mhs'] ?></option>
                                        <?php } ?>
                                    </select>
                                </label>
                                <label class="mb-3 top-label">
                                    <span class="text-black"><strong>PROGRAM STUDI</strong></span>
                                    <select class="form-control"  required id="kd_prog"  name="kd_prog" >
                                        <option value="" > -- Select Program Studi -- </option>
                                        <?php foreach($prodi as $val){ ?>
                                            <option value="<?= $val['kd_prog'] ?>"> <?= $val['nama_prog'] ?></option>
                                        <?php } ?>
                                    </select>
                                </label>

                                <label class="mb-3 top-label">
                                    <input class="form-control" type="text" required name="nama" placeholder="Input Nama Lengkap"/>
                                    <span class="text-black"><strong>NAMA LENGKAP</strong></span>
                                </label>
                                <label class="mb-3 top-label">
                                    <input class="form-control" required name="nik" type="number" placeholder="Input Nomor Induk Kependudukan (NIK)"/>
                                    <span class="text-black"><strong>Nomor Induk Kependudukan (NIK)</strong></span>
                                </label>
                                <label class="mb-3 top-label">
                                    <input class="form-control" required type="email" name="email" placeholder="Input E-Mail"/>
                                    <span class="text-black"><strong>E-MAIL</strong></span>
                                </label>
                                <label class="mb-3 top-label">
                                    <input class="form-control" required name="no_hp" type="number" placeholder="Input No Hp"/>
                                    <span class="text-black"><strong>NO. HP</strong></span>
                                </label>
                                <label class="mb-3 top-label">
                                    <input class="form-control" required name="tahun_lulus" type="number" placeholder="Input Tahun Lulus" />
                                    <span class="text-black"><strong>TAHUN LULUS</strong></span>
                                </label>


                                <button class="btn btn-icon btn-icon-end btn-outline-primary " type="submit">
                                    <span>Daftar</span>
                                    <i data-acorn-icon="chevron-save"></i>
                                </button>

                            </form>

                        </div>

                    <?php } else { ?>

                        <div class="card-body ">
                            <div class="mb-1 h2 title d-none d-sm-block">Form Pendaftaran </div>
                            <hr>
                            <div class="mb-1 h4 title d-none d-sm-block"><b>Tidak Ada Gelombang Pendaftaran </b></div>
                        </div>

                    <?php } ?>

                <?php } ?>

            </div>

        </section>

    </div>
    <!-- Left Sidebar End -->

    <!-- Right Sidebar Start -->
    <div class="col-lg-4 col-12">

        <div class="card w-100 sw-md-50 sh-40 hover-img-scale-up mb-5">
            <img src="<?= base_url('assets/')?>img/banner/cta-standard-1.webp" class="card-img h-100 scale" alt="card image">
            <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                <div>
                    <div class="cta-1 mb-3 text-black w-95 ">Panduan Penerimaan Mahasiswa Baru</div>
                    <div class="w-70 text-black"> <b>Gelombang <?= $gel_daftar['gel'] ?></b>
                        <br>
                        ( <?= date_format(date_create($gel_daftar['tgl_awal']), "d M Y") ?> - <?= date_format(date_create($gel_daftar['tgl_akhir']), "d M Y") ?> ) <br>
                        Brosur dan Biaya Kuliah <br> Download di sini. </div>
                </div>
                <div>
                    <a href="<?= base_url('upload/user_guide.pdf') ?>" target="_blank" class="btn btn-icon btn-icon-start btn-primary mt-3 stretched-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-chevron-right undefined"><path d="M7 4L12.6464 9.64645C12.8417 9.84171 12.8417 10.1583 12.6464 10.3536L7 16"></path></svg>
                        <span>Panduan PMB</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="cta-2 mb-4">
                        Info Lebih Lanjut Hubungi
                    <br>
                    Nomor :
                    <span class="text-primary">08577-888-7871 <br> ( WhatsApp Only )</span>
                </h6>
                <a href="https://wa.me/6285778887871?text=Halo%20Admin%20PMB" target="_blank" class="btn btn-gradient-primary me-2">
                    WhatsApp  <i class=" icon-10 bi-whatsapp"></i>
                </a>
                <!-- <a href="#" class="btn btn-outline-primary me-2">Learn More</a> -->
            </div>
        </div>

    </div>
    <!-- Right Sidebar End -->

</div>

</div>
