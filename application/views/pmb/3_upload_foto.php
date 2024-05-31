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

<!-- Upload Foto Content Start -->
<div class="card">
    <div class="card-body">
        <h2><strong>Upload Foto</strong></h2>
        <p>Lengkapi biodata diri Anda dengan benar</p>
        <hr class="mb-2">

        <!-- Notif -->
        <div class="alert alert-warning mt-4" role="alert">
            <p>Anda belum melakukan <b>Finalisasi Data !!</b></p>
            <hr>
            <p>Setelah melengkapi biodata diri, upload foto, dan upload berkas segera lakukan <b>finalisasi data</b> untuk dapat megikuti tahap selanjutnya.</p>
        </div>

        <form class="tooltip-end-top" action="<?= base_url('pmb/action_upload_foto');?>" enctype="multipart/form-data" method="POST">
            <h5> Pilih Foto<span style="color:red;">*</span> </h5>
            <hr class="mb-2">
            <div class="form-input mb-5">
                <div class="preview1">
                    <img id="file-ip-1-preview">
                </div>
                <input type="text" name="no_pendaftaran" value="<?php echo $no_pendaftaran ?>" hidden>
                <input required type="file" class="form-control" name="foto_profil[]" id="file-ip-1" accept="image/*" onchange="showPreview(event);" style="width:250px;">
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
<!-- Upload Foto Content End -->


<script>
	function showPreview(event){
        if(event.target.files.length > 0){
            var src = URL.createObjectURL(event.target.files[0]);
            var preview1 = document.getElementById("file-ip-1-preview");
            preview1.src = src;
            preview1.style.display = "block";
        }
    }
</script>

