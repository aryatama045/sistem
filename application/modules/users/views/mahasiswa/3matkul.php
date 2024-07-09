<section class="scroll-section" >

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th colspan='3' scope="col">Semester</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>


            <?php if($data_matkulsmt){ $no=0;
                foreach($data_matkulsmt as $key => $val)  { $no++; ?>

                <tr>
                    <th scope="row"> <?= $no ?></th>
                    <td colspan='3'>
                        SEMESTER <b><?= $val['smt']; ?> </b>
                    </td>
                    <td>
                    <a
                        class="btn btn-primary mb-1" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        href="#collapseSmt<?= $val['smt'] ?>"
                        aria-controls="collapseSmt<?= $val['smt'] ?>" >
                        Detail Matkul
                    </a>
                    </td>
                </tr>

                    <?php $detail_matkul = $this->Model_global->getMatkulPersmt($val['smt']); ?>

                    <?php foreach ($detail_matkul as $key2 => $val2) { ?>
                    <tr class="collapse" id="collapseSmt<?= $val['smt'] ?>">
                        <td colspan='2'></td>
                        <td>
                            <b> <?= $val2['kode_matkul']; ?> - <?= $val2['nama_matkul']; ?> </b>
                        </td>
                        <td><b><?= $val2['sks']; ?></b></td>
                        <td></td>
                    </tr>
                    <?php } ?>

            <?php }

                }else{ ?>

                <tr>
                    <td colspan='4' class="text-center">
                        Tidak Ada Berkas
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>

</section>