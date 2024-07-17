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
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td>NIM</td>
                            <td>2320001</td>
                        </tr>
                        <tr>
                            <td>Periode Bayar</td>
                            <td>2024/2025 GENAP</td>
                        </tr>
                    </tbody>
                </table>


                <div class="row g-0 mt-4">
                    <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                        <div class="w-100 d-flex sh-1"></div>
                        <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                            <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative"></div>
                        </div>
                        <div class="w-100 d-flex h-100 justify-content-center position-relative">
                            <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="h-100">
                            <div class="d-flex flex-column justify-content-start">
                                <div class="row">
                                    <div class="col ps-3">
                                        <div class="d-flex flex-column">
                                            <div class="heading stretched-link"><strong> Uang Pangkal dan Bangunan I</strong></div>
                                            <div class="text-alternate">Tanggal Tagihan : 20 Agustus 2024</div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="cta-4 sh-3 d-flex align-items-center"><strong>Rp. 3.500.000</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                        <div class="w-100 d-flex sh-1"></div>
                        <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                            <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative"></div>
                        </div>
                        <div class="w-100 d-flex h-100 justify-content-center position-relative">
                            <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                        </div>
                    </div>
                    <div class="col mb-4">
                        <div class="h-100">
                            <div class="d-flex flex-column justify-content-start">
                                <div class="row">
                                    <div class="col ps-3">
                                        <div class="d-flex flex-column">
                                            <div class="heading stretched-link"><strong> SPP Semester I</strong></div>
                                            <!-- <div class="text-alternate">Tanggal Tagihan : 20 Agustus 2024</div> -->
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="cta-4 sh-3 d-flex align-items-center"><strong>Rp. 4.000.000</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-0">
                    <div class="col pe-4 d-flex flex-column justify-content-between align-items-end">
                        <div class="sh-3 d-flex text-black align-items-center">Total Tagihan</div>
                    </div>
                    <div class="col-auto d-flex flex-column justify-content-between align-items-end">
                        <div class="cta-4 sh-3 d-flex align-items-center"><strong>  Rp. 7.500.000  </strong></div>
                    </div>
                </div>

                <div class="row g-0">
                    <div class="col-auto sw-1 d-flex flex-column justify-content-center align-items-center position-relative me-4">
                        <div class="w-100 d-flex sh-1"></div>
                        <div class="rounded-xl shadow d-flex flex-shrink-0 justify-content-center align-items-center">
                            <div class="bg-gradient-light sw-1 sh-1 rounded-xl position-relative"></div>
                        </div>
                        <div class="w-100 d-flex h-100 justify-content-center position-relative">
                            <div class="line-w-1 bg-separator h-100 position-absolute"></div>
                        </div>
                    </div>

                    <div class="col mb-4">
                        <div class="h-100">
                        <div class="d-flex flex-column justify-content-start">
                            <div class="row">
                                <div class="col ps-3">
                                    <div class="d-flex flex-column">
                                        <div class="heading stretched-link"><strong> Detail Cicilan</strong></div>
                                        <!-- <div class="text-alternate">Tanggal Tagihan : 20 Agustus 2024</div> -->
                                    </div>
                                </div>
                            

                                <table class="table">
                                    <thead>
                                        <th>Cicilan </th>
                                        <th>Tipe</th>
                                        <th>Jumlah</th>
                                        <th>Waktu</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($detil_bayar as $key => $val) { ?>
                                        <tr>
                                            <td><?= $val['ke'] ?></td>
                                            <td><?= $val['tipe'] ?></td>
                                            <td><?= $val['nilai'] ?></td>
                                            <td><?= $val['wkt_bayar'] ?></td>
                                            <td><?= $val['keterangan'] ?></td>
                                        </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-0">
                    <div class="col pe-4 d-flex flex-column justify-content-between align-items-end">
                        <div class="sh-3 d-flex text-black align-items-center">Total Bayar</div>
                    </div>
                    <div class="col-auto d-flex flex-column justify-content-between align-items-end">
                        <div class="cta-4 sh-3 d-flex align-items-center"><strong>  Rp. <?= $totalbayar['total'] ?>  </strong></div>
                    </div>
                </div>

                <div class="row g-0">
                    <div class="col pe-4 d-flex flex-column justify-content-between align-items-end">
                        <div class="sh-3 d-flex text-black align-items-center">Sisa Tagihan</div>
                    </div>
                    <div class="col-auto d-flex flex-column justify-content-between align-items-end">
                        <div class="cta-4 sh-3 d-flex align-items-center"><strong>  Rp. <?= $sisa_bayar['sisa'] ?>  </strong></div>
                    </div>
                </div>

            </div>

        </div>


	</div>
</div>
<!--  -->