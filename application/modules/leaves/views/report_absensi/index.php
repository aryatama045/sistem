	<div class="row">
		<div class="col-12">
			<h1>Report Cuti</h1>
			<div class="top-right-button-container">
			</div>
			<div class="separator"></div>
			<br>
		</div>
	</div>

	<!-- <div id="messages"></div> -->

	<div class="row">
		<div class="col-12 ">
			<div class="card">
				<div class="card-body">
				<form action="report/print_action" method="post" id='form-print'>
					<div class="row">
						<div class="col-md-7">
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">TANGGAL</label>
								<div class="col-sm-8">
									<input type="hidden" name="action" id="action" />
									<div class="input-group">
									<input class="input-sm form-control" type="date" name="tanggal1" id="tanggal1" value="<?= date("Y") . "-" . date("m") . "-" . "01"; ?>" placeholder="FROM DATE" required>
									<span class="input-group-addon"></span>
									<input class="input-sm form-control" type="date" name="tanggal2" id="tanggal2" value="<?= date("Y-m-t", strtotime(date("Y-m-t"))); ?>" placeholder="TO DATE" required>
									</div>
								</div>
							</div>
							<div class="form-group row ">
                                <label class="col-sm-4 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input placeholder="Search by nip" id="nip" name="nip" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row ">
                                <label class="col-sm-4 col-form-label">NAMA LENGKAP</label>
                                <div class="col-sm-8">
                                    <input placeholder="Search by nama lengkap" id="nama_lengkap" name="nama_lengkap" type="text" class="form-control" >
                                </div>
                            </div>
							<div class="form-group row ">
                                <label class="col-sm-4 col-form-label">NO. DOKUMEN</label>
                                <div class="col-sm-8">
                                    <input placeholder="Search by no. dokumen" id="no_dok" name="no_dok" type="text" class="form-control" >
                                </div>
                            </div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA DIVISI</label>
								<div class="col-sm-8">
									<select class="form-control" name="nm_divisi" id="nm_divisi">
										<option value="">--PILIH DIVISI--</option>
										<?php foreach($nm_divisi as $d) : ?>
										<option value="<?php echo $d->divisi_id ?>"><?php echo $d->nama_divisi ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA DEPARTEMENT</label>
								<div class="col-sm-8">
								<select class="form-control" name="nm_departement" id="nm_departement">
									<option value="">--PILIH SEMUA DEPARTMENT--</option>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">NAMA STORE</label>
								<div class="col-sm-8">
								<select class="form-control select2-single" name="nm_store" id="nm_store">
									<option value="">--PILIH SEMUA STORE--</option>
								</select>
								</div>
							</div>

							<div class="form-group row mb-0">
								<div class="col-sm-4"></div>
								<div class="col-sm-8 align-self-end">
									<button type="button" class="btn btn-outline-primary" id='btn-pdf-action' title="Print PDF">P D F</button>
									<button type="button" class="btn btn-outline-primary" id='btn-excel-action' title="Export Excel">EXCEL</button>
									<!-- <button type="button" id="btn-tampil" class="btn btn-outline-primary">Tampilkan</button> -->
								</div>
							</div>

						</div>
					</div>
				</form>
				</div>
				<div class="card-body">
					<table id="tableAbsen" class="table table-bordered data-table">
						<thead>
							<tr>
								<th>NO. DOC </th>
								<th>NIP </th>
								<th>NAMA LENGKAP</th>
								<th>TGL. TIDAK MASUK</th>
								<th>JABATAN</th>
								<th>DEPARTEMENT </th>
								<th>DIVISI</th>
								<th>STORE</th>
								<th>STATUS</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

<div class="modal fade" id="DetailReport" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="DetailReportLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p id="header_report"></p>
				<hr>
				<p id="data_approve"></p>
				<p id="data_report"></p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary"
					data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php //echo $this->load->assets('report_absensi', 'index', 'js');?>
<script>
	var text;
	var textapp;
	$(document).ready(function(){
		$('#nm_divisi').change(function(){ 
			var id = $('[name=nm_divisi]').val();
			// alert(id);
			$.ajax({
				url : "<?php echo site_url('leaves/report/get_data_departement');?>",
			method : "POST",
			data : {id: id},
			async : true,
			dataType : 'json',
			success: function(data){
				var html = '';
				var i;
				html += '<option value="">--PILIH DEPARTMENT--</option>';
				for(i=0; i<data.length; i++){
					// alert(data[i].dept_id);
					html += '<option value='+data[i].dept_id+'>'+data[i].nama_dept+'</option>';
				}
				$('#nm_departement').html(html);
			}
			});
			tableAbsen.ajax.reload();
			return false;
		});


		$('#nm_departement').change(function(){ 
			var id = $('[name=nm_departement]').val();
			var divisi_id = $('[name=nm_divisi]').val();
			// alert(divisi_id);
			$.ajax({
				url : "<?php echo site_url('leaves/report/get_data_store');?>",
			method : "POST",
			data : {id: id,divisi_id: divisi_id},
			async : true,
			dataType : 'json',
			success: function(data){
				var html = '';
				var i;
				html += '<option value="">--PILIH STORE--</option>';
				for(i=0; i<data.length; i++){
					// alert(data[i].dept_id);
					html += '<option value='+data[i].kd_store+'> '+data[i].kd_store+' - '+data[i].nama_store+'</option>';
				}
				$('#nm_store').html(html);
			}
			});
			tableAbsen.ajax.reload();
			return false;
		});


		$('#btn-pdf-action').click(function (e) {
				var tanggal1 = $('[name=tanggal1]').val();
				var tanggal2 = $('[name=tanggal2]').val();
				// alert(tanggal2);
			$('#action').val('print');
			$("#form-print").attr('target', 'new');
			$("#form-print").submit();
			e.preventDefault();
		});

		$('#btn-excel-action').click(function (e) {
			var tanggal1 = $('[name=tanggal1]').val();
			var tanggal2 = $('[name=tanggal2]').val();
		$('#action').val('excel');
		$("#form-print").removeAttr('target');
		$("#form-print").submit();
		e.preventDefault();
		});

				// initialize the datatable 
		tableAbsen = $('#tableAbsen').DataTable({
			// 'orderCellsTop': true,
			// 'fixedHeader': true,
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'scrollX': true,
			'ajax': {
				'url': base_url + 'leaves/report/fetchDataAbsen',
				'type': 'POST',
							'data':function(data) {
								data.no_dok = $('#no_dok').val();
								data.nip = $('#nip').val();
								data.nama_lengkap = $('#nama_lengkap').val();
								data.tanggal1 = $('#tanggal1').val();
								data.tanggal2 = $('#tanggal2').val();
								data.id_divisi = $('#nm_divisi').val();
								data.id_dept = $('#nm_departement').val();
								data.kd_store = $('#nm_store').val();
							},
			},
			'order': [0, 'ASC'],
			'columnDefs': [{
					targets: 0,
					className: 'text-left'
				},
				{
					targets: 1,
					className: 'text-left'
				},
			]
		});
		$("#tableAbsen_filter").css("display", "none");

		$('.search-input-text').on('keyup', function(event) { // for text boxes
			var i = $(this).attr('data-column'); // getting column index
			var v = $(this).val(); // getting search input value
			var keycode = event.which;
			if (keycode == 13) {
				tableAbsen.columns(i).search(v).draw();
			}
		});
		$('.search-input-select').on('change', function() { // for select box
			var i = $(this).attr('data-column');
			var v = $(this).val();
			tableAbsen.columns(i).search(v).draw();
		});

		$('#btn-tampil').click(function(){ //button filter event click
			tableAbsen.ajax.reload();  //just reload table
		});

		$('#tanggal1').on('change', function(){ //button filter event click
			tableAbsen.ajax.reload();  //just reload table
		});

		$('#tanggal2').on('change', function(){ //button filter event click
			tableAbsen.ajax.reload();  //just reload table
		});

		$('#nm_store').on('change', function(){ //button filter event click
	        tableAbsen.ajax.reload();  //just reload table
		});

		$('#nip').on('change', function() { //button filter event click
			tableAbsen.ajax.reload(); //just reload table
		});

		$('#nama_lengkap').on('change', function() { //button filter event click
			tableAbsen.ajax.reload(); //just reload table
		});

		$('#no_dok').on('change', function() { //button filter event click
			tableAbsen.ajax.reload(); //just reload table
		});

	});

	function detail_doc(id) {
		//Ajax Load data from ajax
		$.ajax({
			url: base_url + 'leaves/report/detail_doc/' + id,
			type: "GET",
			dataType: "JSON",
			success: function(data) {

				$('#DetailReport').modal('show'); // show bootstrap modal when complete loaded
				$('.modal-title').text('Detail - ' + id); // Set title to Bootstrap modal title
				header_report ="";
				header_report += '<div class="form-group row">' +
					'<label class="col-sm-4 col-form-label"> NIP</label>' +
					'<div class="col-sm-8"> : <b>' + data.nip + '</b></div> </div>' +

					'<div class="form-group row">' +
					'<label class="col-sm-4 col-form-label"> POTONG CUTI</label>' +
					'<div class="col-sm-8"> : <b>' + data.potong + '</b></div> </div>' +

					'<div class="form-group row">' +
					'<label class="col-sm-4 col-form-label"> KETERANGAN</label>' +
					'<div class="col-sm-8"> : <b>' + data.keterangan + '</b></div> </div>';
				document.getElementById("header_report").innerHTML = header_report;

				text = "";
				textapp = "";
				var array = data;
				detailtem(array);
				detailapp(array);
				document.getElementById("data_report").innerHTML = text;

				document.getElementById("data_approve").innerHTML = textapp;
				// $('.data_report').innerHTML = text;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	};

	function detailtem(array) {
		text += '<h5>Detail Cuti</h5><hr> <table class="table table-bordered data-table">';
		text += '<thead>' +
        '<tr>' +
        '<th>TGL CUTI</th>' +
		'<th>HARI</th>' +
        '<th>KETERANGAN</th>' +
        '</tr>' +
        '</thead><tbody>';
		for (val of array.data) {
			console.log(val);
			text +=
				'<tr>' +
				'<td>' + val[0] + '</td>' +
				'<td>' + val[1] + '</td>' +
				'<td>' + val[2] + '</td></tr>';
		}
		text += '</tbody></table>';
	};

	function detailapp(array) {
		textapp += '<h5>Detail Approve</h5><hr> <table class="table table-bordered data-table">';
		textapp += '<thead>' +
        '<tr>' +
        '<th>App</th>' +
		'<th>Tgl App</th>' +
        '<th>Tgl Rej</th>' +
		'<th>Keterangan</th>' +
        '</tr>' +
        '</thead><tbody>';
		for (val of array.approve) {
			console.log(val);
			textapp +=
				'<tr>' +
				'<td>' + val[0] + '</td>' +
				'<td>' + val[1] + '</td>' +
				'<td>' + val[2] + '</td>' +
				'<td>' + val[3] + '</td></tr>';
		}
		textapp += '</tbody></table>';
	};

</script>


