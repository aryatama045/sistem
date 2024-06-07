<section class="scroll-section" id="basic">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Dokumen</th>
                <th scope="col">File Berkas</th>
            </tr>
        </thead>
        <tbody>


            <?php if($dok_pmb){ $no=0; foreach($dok_pmb as $key => $val)  { $no++; ?>

            <tr <?= ($val['validasi'])?'class="table-active"': ''; ?> >
                <th scope="row"> <?= $no ?></th>
                <td><?= $val['nama_dok']; ?> <?= ($val['validasi'])?'': '<span style="color:red;">*</span>'; ?> </td>
                <td>
                    <?php
                        $filename=$val['dokumen'];
                        $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
                    ?>

                    <?php if($file_ext =='pdf'){ ?>
                        <a class="test-popup-link btn btn-outline-success mb-1" target="_blank"
                            href="<?= base_url('upload/berkas/'.$val['no_pendaftaran'].'/'.$val['dokumen']) ?>" >View PDF <i class=""></i></a>
                    <?php } else { ?>
                        <a class="test-popup-link btn btn-outline-success mb-1" data-fancybox="gallery" data-src="<?= base_url('upload/berkas/'.$val['no_pendaftaran'].'/'.$val['dokumen']) ?>">
                            View Berkas<i class=""></i></a>
                    <?php } ?>
                </td>
            </tr>

            <?php } }else{ ?>

                <tr>
                    <td colspan='4' class="text-center">
                        Tidak Ada Berkas
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>

</section>