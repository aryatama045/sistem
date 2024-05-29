
<!-- Biodata Content Start -->
<div class="card">
    <div class="card-body">
        <h2> Biodata Diri</h2>
        <p>Lengkapi biodata diri Anda dengan benar</p>
        <hr class="mb-2">

        <!-- Notif -->
        <div class="alert alert-warning mt-4" role="alert">
            <p>Anda belum melakukan <b>Finalisasi Data !!</b></p>
            <hr>
            <p>Setelah melengkapi biodata diri, upload foto, dan upload berkas segera lakukan <b>finalisasi data</b> untuk dapat megikuti tahap selanjutnya.</p>
        </div>

        <!-- Form Biodata Diri -->
        <div class="mb-5">

            <!-- Nav-Tab Data Diri & Orang Tua -->
            <div class="nav" role="tablist">
                <a class="nav-link active" data-bs-toggle="tab"
                    href="#dataPribadiTab" role="tab">
                    <h5><span class="align-middle">Data Pribadi</span></h5>
                </a>
                <a class="nav-link" data-bs-toggle="tab"
                    href="#orangTuaTab" role="tab">
                    <h5><span class="align-middle">Orang Tua</span></h5>
                </a>
            </div>
            <hr class="mb-2">

            <div class="tab-content">
                <!-- Data Diri Tab -->
                <div class="tab-pane fade show active" id="dataPribadiTab" role="tabpanel">
                    <form class="tooltip-end-top"  action="<?= base_url('pmb/action_biodata_diri');?>" method="POST">
                        <input type="text" name="no_pendaftaran" value="<?php echo $no_pendaftaran ?>" hidden>
                        <!-- No Daftar & Tanggal -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" placeholder="<?= $no_pendaftaran ?>" readonly />
                                    <span>NOMOR DAFTAR</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" placeholder="<?= date('d-M-Y',strtotime($pmb['tgl_input'])) ?>" readonly/>
                                    <span>TANGGAL PENDAFTARAN</span>
                                </label>
                            </div>
                        </div>

                        <!-- Nama Lengkap & Jenis Kelamin -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" required value="<?= capital($pmb['nama']) ?>" name="nama_lengkap" />
                                    <span class="text-black">NAMA LENGKAP <small style="color:red;">*</small></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 top-label">
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <?php  if(!empty($pmb['jenis_kelamin'])) { ?>
                                            <option value="<?= $pmb['jenis_kelamin']?>"> -- <?= $pmb['jenis_kelamin'] ?> --</option>
                                        <?php }else{ ?>
                                            <option value=""> -- Select Jenis Kelamin --</option>
                                        <?php } ?>

                                        <option value="L"> LAKI-LAKI</option>
                                        <option value="P"> PEREMPUAN</option>
                                    </select>
                                    <span class="text-black">JENIS KELAMIN <small style="color:red;">*</small></span>
                                </div>
                            </div>
                        </div>

                        <!-- Tempat Lahir & Agama -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="tempat_lahir" required/>
                                    <span class="text-black">TEMPAT LAHIR <small style="color:red;">*</small></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 top-label">
                                    <select class="form-control" name="agama" required>
                                        <option value="" >-- Select Agama --</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                    </select>
                                    <span class="text-black">AGAMA <small style="color:red;">*</small></span>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Lahir & Ibu Kandung -->
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="tanggal_lahir" required id="selectTanggal" />
                                    <span class="text-black">TANGGAL LAHIR <small style="color:red;">*</small></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="ibu_kandung" required/>
                                    <span class="text-black">NAMA IBU KANDUNG <small style="color:red;">*</small></span>
                                </label>
                            </div>
                        </div>

                        <h5>Data Lainnya</h5> <hr class="mb-2">
                        <!-- NIK & Telepon -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="nik" value="<?= $pmb['nik'] ?>" required/>
                                    <span class="text-black">NIK <small style="color:red;">*</small></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="telepon" value="" />
                                    <span>TELEPON</span>
                                </label>
                            </div>
                        </div>

                        <!-- NISN & No Hp -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="nisn" value=""  required/>
                                    <span class="text-black">NISN <small style="color:red;">*</small></span>

                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="nomor_hp" value="" />
                                    <span>NOMOR HP.</span>
                                </label>
                            </div>
                        </div>

                        <!-- NPWP & Email -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="npwp" value=""  />
                                    <span class="text-black"><b>NPWP</b></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" readonly name="email" value="<?= $pmb['email'] ?>" required/>
                                    <span class="text-black">EMAIL <small style="color:red;">*</small></span>

                                </label>
                            </div>
                        </div>

                        <!-- Asal SMA/SMK & Kewarganegaraan -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="asal_sekolah"  />
                                    <span class="text-black"><b>ASAL SMA/SMK</b></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="kewarganegaraan"   required/>
                                    <span class="text-black">KEWARGANEGARAAN<small style="color:red;">*</small></span>
                                </label>
                            </div>

                        </div>

                        <!-- Jenis Tinggal -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="jenis_tinggal"  />
                                    <span class="text-black">JENIS TINGGAL</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tempat Tinggal -->
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="mb-3 top-label">
                                    <textarea name="alamat" class="form-control"></textarea>
                                    <span class="text-black">ALAMAT<small style="color:red;">*</small></span>
                                </label>
                            </div>
                        </div>

                        <!-- Jenis Tinggal -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="kelurahan" value="" required/>
                                    <span class="text-black">KELURAHAN <small style="color:red;">*</small></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="kecamatan" value="" required/>
                                    <span class="text-black">KECAMATAN <small style="color:red;">*</small></span>
                                </label>
                            </div>
                        </div>

                        <!-- Rt-Rw-Kode Pos -->
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="rt"/>
                                    <span>RT</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="rw"/>
                                    <span>RW</span>
                                </label>
                            </div>
                            <div class="col-md-4">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="kode_pos"/>
                                    <span>KODE POS</span>
                                </label>
                            </div>
                        </div>

                        <!-- Button Update -->
                        <div class="mt-5">
                            <button class="btn btn-icon btn-icon-end btn-primary" type="submit">
                                <span>Update</span>
                                <i data-acorn-icon="save"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Orang Tua Tab -->
                <div class="tab-pane fade" id="orangTuaTab" role="tabpanel">
                    <form class="tooltip-end-top" action="<?= base_url('pmb/action_orang_tua');?>" method="POST">
                        <input type="text" name="no_pendaftaran" value="<?php echo $no_pendaftaran ?>" hidden>
                        <!-- No Daftar & Tanggal -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="nama_ayah" />
                                    <span>NOMOR DAFTAR</span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-3 top-label">
                                    <input class="form-control" name="nama_ibu"/>
                                    <span>TANGGAL PENDAFTARAN</span>
                                </label>
                            </div>
                        </div>

                        <!-- Button Update -->
                        <div class="mt-5">
                            <button class="btn btn-icon btn-icon-end btn-primary" type="submit">
                                <span>Update</span>
                                <i data-acorn-icon="save"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- Biodata Content End -->

<script type="text/javascript">
	window.base_url = '<?php echo base_url() ?>';
</script>


<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('#selectTanggal').datepicker({
                autoclose: true,
            });
        });
    });
</script>