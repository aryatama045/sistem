

<div class="card mb-5">
    <div class="card-body">
        <!-- Greeting -->
        <h2><strong>Selamat Datang, <?= capital($pmb['nama']); ?></strong> </h2>
        <p>Lanjutkan proses pendaftaran dengan mengisi data diri anda secara lengkap dan melakukan upload berkas.</p>

        <hr class="mb-2">

        <!-- Status Terkini Dots -->
        <div class="border-0 pb-0 wizard mt-5 mb-5" id="wizardBasic">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link  text-center <?php if($status>'2'){ echo 'done';} ?>" role="tab" data-index="1" >
                        <div class="mb-1 title d-none d-sm-block">Biodata Pendaftar</div>
                    </a>
                </li>
                <li class="nav-item " role="presentation">
                    <a class="nav-link text-center <?php if($status>'3'){ echo 'done';} ?>"role="tab" data-index="2">
                        <div class="mb-1 title d-none d-sm-block">Upload Foto</div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-center <?php if($status>'4'){ echo 'done';} ?>" role="tab" data-index="3">
                        <div class="mb-1 title d-none d-sm-block">Upload Berkas</div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-center <?php if($status>'5'){ echo 'done';} ?>" role="tab" data-index="4">
                        <div class="mb-1 title d-none d-sm-block">Pembayaran</div>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-center <?php if($status=='6'){ echo 'done';} ?>"  role="tab" data-index="5">
                        <div class="mb-1 title d-none d-sm-block">Finalisasi</div>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Notif -->
        <div class="alert alert-warning mt-4" role="alert">
            <p><strong>Anda belum melakukanFinalisasi Data !!</strong></p>
            <hr>
            <p>Setelah melengkapi biodata diri, upload foto, dan upload berkas segera lakukan <b>finalisasi data</b> untuk dapat megikuti tahap selanjutnya.</p>
        </div>

    </div>
</div>