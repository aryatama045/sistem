<?php
	$mod = to_strip(lowercase($modul));
	$func = to_strip(lowercase($pagetitle));
	$table_data = $func; ?>

<div class="row">
	<div class="col">

        <!-- Title and Top Buttons Start -->
		<div class="page-title-container">
			<div class="row">
				<!-- Title Start -->
				<div class="col-12 col-md-7">
					<h1 class="mb-0 pb-0 display-4" id="title"><?= $pagetitle ?></h1>
					<?php $this->load->view('templates/breadcrumb'); ?>
				</div>
				<!-- Title End -->

			</div>
		</div>
		<!-- Title and Top Buttons End -->

		<div class="card">
			<div class="card-body">
				<table id="<?= $table_data ?>" class="table table-bordered responsive nowrap stripe w-100">
					<thead class="mt-4">
						<tr>
							<th class="text-bold text-uppercase">Kode Matkul</th>
							<th class="text-bold text-uppercase">Nama Matkul</th>
                            <th class="text-bold text-uppercase">SKS</th>
                            <th class="text-bold text-uppercase">Dosen </th>
                            <th class="text-bold text-uppercase">Ruang </th>
                            <th class="text-bold text-uppercase">Hari & Jam</th>
						</tr>
					</thead>
                    <tbody>
                        <?php foreach ($data_krs as $key => $val) { ?>

                        <tr>
                            <td><strong><?= $val['kode_matkul'] ?></strong> </td>
                            <td> <?= $val['nama_matkul'] ?></td>
                            <td><strong> <?= $val['sks'] ?></strong></td>
                            <td><?= $val['gelar_depan'] ?> <?= $val['nama'] ?> <?= $val['gelar_blk'] ?></td>
                            <td><strong> <?= $val['ruang'] ?></strong></td>
                            <td><strong> <?= $val['hari'] ?> / <?= $val['jam'] ?></strong></td>
                        </tr>

                        <?php  } ?>
                    </tbody>
				</table>
			</div>
		</div>

	</div>
</div>
<!--  -->