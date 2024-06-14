

<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>


<section class="scroll-section" id="basic">
    <form class="row g-3" action="<?= base_url($mod.'/'.$func.'/berkas_validasi/'.$pmb_validasi['no_pendaftaran']); ?>" method="POST">

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Dokumen</th>
                    <th scope="col">File Berkas</th>
                    <th scope="col">Ket. Validasi</th>
                    <th scope="col">Checklist</th>
                </tr>
            </thead>
            <tbody>


                <?php $no=0; foreach($dok_pmb as $key => $val)  { $no++; ?>

                    <tr <?= ($val['validasi'])?'class="table-active"': ''; ?> >
                        <th scope="row"> <?= $no ?></th>
                        <td><?= $val['nama_dok']; ?> <?= ($val['validasi'])?'': '<span style="color:red;">*</span>'; ?>
                            <input name="nama_dok[]" value="<?= $val['nama_dok']; ?>" hidden/>
                        </td>
                        <td>
                            <?php
                                $filename=$val['dokumen'];
                                $file_ext = pathinfo($filename,PATHINFO_EXTENSION);
                            ?>

                            <?php if($file_ext =='pdf'){ ?>
                                <a class="test-popup-link btn btn-outline-success mb-1" target="_blank"
                                    href="<?= base_url('upload/berkas/'.$val['no_pendaftaran'].'/'.$val['dokumen']) ?>" >View PDF <i class=""></i></a>
                            <?php } else { ?>
                                <a  class="test-popup-link btn btn-outline-success mb-1" data-fancybox="gallery" data-src="<?= base_url('upload/berkas/'.$val['no_pendaftaran'].'/'.$val['dokumen']) ?>">
                                    View Berkas<i class=""></i></a>
                            <?php } ?>
                        </td>
                        <td>
                            <textarea name="ket_validasi[]" class="form-control" <?= ($val['ket_validasi'])?'': 'placeholder="Input Keterangan"'; ?> ><?= ($val['ket_validasi'])?$val['ket_validasi']: ''; ?></textarea>
                        </td>
                        <td>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="id[]" value="<?= $val['id']; ?>" type="checkbox"  <?= ($val['validasi'])?'checked ': ''; ?> id="valid<?= $val['id'] ?>">
                                    <label class="form-check-label" for="valid<?= $val['id'] ?>">Valid</label>
                                </div>
                            </div>
                        </td>
                    </tr>

                <?php } ?>

            </tbody>
        </table>

        <div class="col-12">
            <button type="submit" class="btn btn-primary"><i data-acorn-icon="save"></i> Submit Validasi</button>
        </div>

        <div class="col-12 mt-2">
            <label class="form-check-label" ><strong> Note : </strong><span style="color:red">*</span> Checklist Berkas yang sudah divalidasi</label>
        </div>

    </form>
</section>