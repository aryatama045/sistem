<style>
    .center {
        height:100%;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    img#preview-bukti-bayar {
        width: 250px;
        margin-bottom: 2em;
    }
</style>


<form class="tooltip-end-top mb-5" action="<?= base_url('pmb/action_pembayaran_pmb');?>" enctype="multipart/form-data" method="POST">

    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2> <strong>Pembayaran Tagihan</strong> </h2>
                    <p>Silahkan cek kembali data Anda dengan benar</p>
                    <hr class="mb-2">

                    <h5> <b>Upload Bukti Pembayaran<span style="color:red;">*</span> </b></h5>
                    <hr class="">
                    <div class="form-input ">
                        <div class="preview1">
                            <img id="preview-bukti-bayar">
                        </div>
                        <input type="text" name="no_pendaftaran" value="<?php echo $no_pendaftaran ?>" hidden>
                        <input required type="file" class="form-control" name="foto_bukti[]" id="file-ip-1" accept="image/*" onchange="showPreviewBB(event);" style="width:250px;">
                    </div>

                    <!-- Notif -->
                    <div class="alert alert-primary mt-4" role="alert">
                        <p> <b>Keterangan :</b></p>
                        <ul>
                            <li>Tipe Foto yang dibolehkan JPG , PNG</li>
                            <li>Maksimal ukuran setiap file adalah 1mb</li>
                            <li><span style="color:red;">*</span> (Require/Wajib)</li>
                        </ul>
                    </div>

                    <div class="mt-5">
                        <p class="text-black text-bold-600 mb-1">CONTACT</p>
                        <a href="#" class="d-block body-link mb-1">
                            <i data-acorn-icon="screen" class="me-2" data-acorn-size="17"></i>
                            <span class="align-middle">blainecottrell.com</span>
                        </a>
                        <a href="#" class="d-block body-link">
                            <i data-acorn-icon="email" class="me-2" data-acorn-size="17"></i>
                            <span class="align-middle">contact@blainecottrell.com</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card" style="position:-webkit-sticky; position:sticky; top: 5rem;">
                <div class="card-body mb-n5">
                    <div class="mb-3">
                        <div class="mb-2">
                            <p class="text-black cta-3 mb-1">Transfer Dari Bank<span style="color:red;">*</span></p>
                            <p>
                                <input class="form-control" required name="dari_bank" placeholder="Input Bank Transfer, Contoh : BCA" />
                            </p>
                        </div>
                        <div class="mb-2">
                            <p class="text-black cta-3 mb-1">Atas Nama Pengirim<span style="color:red;">*</span></p>
                            <p>
                                <input class="form-control" required name="nama_pengirim" placeholder="Input Nama Pengirim" />
                            </p>
                        </div>
                        <div class="mb-2">
                            <p class="text-black cta-3 mb-1">Total Bayar</p>
                            <div class="cta-2">
                                <span class="text-black text-muted cta-2"><strong>Rp. 350.000</strong></span>
                            </div>
                        </div>

                        <!-- Notif -->
                        <div class="alert alert-warning mt-4" role="alert">
                            <p style="color:red;"> <b>Pembayaran harus sesuai dengan Total Bayar.</b></p>
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input type="checkbox" class="form-check-input" id="customCheck1">
                        <label class="form-check-label" for="customCheck1">
                            I have read and accept the
                            <a href="#" target="_blank">terms and conditions.</a>
                        </label>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="d-flex flex-column flex-sm-row justify-content-between mb-5 w-100">
                            <button class="btn btn-icon btn-icon-end btn-primary w-100" type="submit">
                                <i data-acorn-icon="credit-card" class="me-2" data-acorn-size="17"></i>
                                <span>Pembayaran</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</form>


<script>
	function showPreviewBB(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var previewbb = document.getElementById("preview-bukti-bayar");
            previewbb.src = src;
            previewbb.style.display = "block";
        }
    }
</script>