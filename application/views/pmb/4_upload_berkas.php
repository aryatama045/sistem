<style>
    .center {
        height:100%;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    img#file-ip-1-preview {
        width: 250px;
        margin-bottom: 2em;
    }
</style>

<!-- Upload Berkas Content Start -->
<div class="card">
    <div class="card-body">
        <h2><strong>Upload Berkas</strong> </h2>
        <p>Lengkapi biodata diri Anda dengan benar</p>
        <hr class="mb-2">

        <!-- Notif -->
        <div class="alert alert-warning mt-4" role="alert">
            <p>Anda belum melakukan <b>Finalisasi Data !!</b></p>
            <hr>
            <p>Setelah melengkapi biodata diri, upload foto, dan upload berkas segera lakukan <b>finalisasi data</b> untuk dapat megikuti tahap selanjutnya.</p>
        </div>

        <form class="tooltip-end-top"  action="<?= base_url('pmb/action_upload_berkas');?>" enctype="multipart/form-data" method="POST">

            <h5> <b>Dokumen yang wajib dilampirkan</b></h5>
            <hr>
            <!-- Dokumen Table Start -->
            <section class="scroll-section" id="basic">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Dokumen</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">Status Validasi</th>
                            <th scope="col">Ket. Validasi</th>
                            <th scope="col">File Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!$get_dok_pmb){ ?>
                        <tr>
                            <th scope="row">1</th>
                            <td>IJAZAH<span style="color:red;">*</span></td>
                            <td></td>
                            <td>Belum Validasi</td>
                            <td></td>
                            <td>
                                <div class="form-input mb-5">
                                    <input type="text" name="no_pendaftaran" value="<?php echo $no_pendaftaran ?>" hidden>
                                    <input type="text" name="dok[]" value="Ijazah" hidden>
                                    <input type="file" class="form-control" name="berkas[]"  style="width:250px;" multiple required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>KTP<span style="color:red;">*</span></td>
                            <td></td>
                            <td>Belum Validasi</td>
                            <td></td>
                            <td>
                                <div class="form-input mb-5">
                                <input type="text" name="dok[]" value="Ktp" hidden>
                                    <input type="file" class="form-control" name="berkas[]"  style="width:250px;" multiple required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Pas Photo 3X4<span style="color:red;">*</span></td>
                            <td></td>
                            <td>Belum Validasi</td>
                            <td></td>
                            <td>
                                <div class="form-input mb-5">
                                    <input type="text" name="dok[]" value="Pas Photo 3X4" hidden>
                                    <input type="file" class="form-control" name="berkas[]" multiple  style="width:250px;" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>Kartu Keluarga <span style="color:red;">*</span></td>
                            <td></td>
                            <td>Belum Validasi</td>
                            <td></td>
                            <td>
                                <div class="form-input mb-5">
                                    <input type="text" name="dok[]" value="Kartu Keluarga" hidden>
                                    <input type="file" class="form-control" name="berkas[]" multiple style="width:250px;" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>Surat Keterangan <br> Tidak Buta Warna <span style="color:red;">*</span></td>
                            <td></td>
                            <td>Belum Validasi</td>
                            <td></td>
                            <td>
                                <div class="form-input mb-5">
                                    <input type="text" name="dok[]" value="Surat Keterangan Tidak Buta Warna" hidden>
                                    <input type="file" class="form-control" name="berkas[]" multiple style="width:250px;" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">6</th>
                            <td>Scan Rapor SMA/SMK<span style="color:red;">*</span></td>
                            <td></td>
                            <td>Belum Validasi</td>
                            <td></td>
                            <td>
                                <div class="form-input mb-5">
                                    <input type="text" name="dok[]" value="Scan Rapor SMA/SMK" hidden>
                                    <input type="file" class="form-control" name="berkas[]" multiple style="width:250px;" required>
                                </div>
                            </td>
                        </tr>

                        <?php }else{ ?>

                            <?php $no=0; foreach($get_dok_pmb as $key => $val)  { $no++; ?>

                            <tr <?= ($val['validasi'])?'class="table-active"': ''; ?> >
                                <th scope="row"> <?= $no ?></th>
                                <td><?= $val['nama_dok']; ?> <?= ($val['validasi'])?'': '<span style="color:red;">*</span>'; ?> </td>
                                <td> Sudah Upload </td>
                                <td><?= ($val['validasi'])?'1': '0'; ?></td>
                                <td><?= $val['ket_validasi']; ?></td>
                                <td>
                                    <div class="form-input mb-5">
                                        <input type="text" name="no_pendaftaran" value="<?= $val['no_pendaftaran']; ?>" hidden>
                                        <input type="text" name="dok[]" value="<?= $val['nama_dok']; ?>" hidden>
                                        <?= ($val['validasi'])?'':
                                        '<input type="file" class="form-control" name="berkas[]"  style="width:250px;" multiple required>'?>
                                    </div>
                                </td>
                            </tr>

                            <?php } ?>

                        <?php } ?>

                    </tbody>
                </table>
            </section>
            <!-- Dokumen Table End -->

            <!-- Notif -->
            <div class="alert alert-primary mt-4" role="alert">
                <p> <b>Keterangan :</b></p>
                <ul>
                    <li>Tipe File yang dibolehkan PDF , JPG , PNG</li>
                    <li>Maksimal ukuran setiap file adalah 5mb</li>
                    <li><span style="color:red;">*</span> (Require/Wajib)</li>
                </ul>
                <br>
                <p> <b>Note :</b> Selama Data Belum Valid, Masih Bisa Di Re-Upload kembali data yang bermasalah</p>
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
<!-- Upload Berkas Content End -->


