
<style>
	td.details-control {
		background: url('././theme/assets/details_open.png') no-repeat center center;
		cursor: pointer;
	}

	tr.shown td.details-control {
		background: url('././theme/assets/details_close.png') no-repeat center center;
	}

	.btn-toolbar.sw-toolbar.sw-toolbar-bottom.justify-content-end {
		display: none;
	}

	.dataTables_scrollHeadInner{
			width: 100% !important;
		}
</style>

	<div class="row">
		<div class="col-12">
			<h1>Verifikasi Ijin & Cuti Dispensasi</h1>
			<div class="separator"></div>
			<br>
		</div>
	</div>

	<div id="messages"></div>

	<?php if($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
		<?php elseif($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo $this->session->flashdata('error'); ?>
		</div>
		<?php endif; ?>
		<?php if(validation_errors()): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo validation_errors(); ?>
		</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-12 ">
			<div class="card">
				<div class="card-body">
					<div id="smartWizardClickable">
						<ul class="card-header">
							<li><a href="#clickable1">Aktif<br /></a></li>
							<li><a href="#table2"> History<br /></a></li>
						</ul>
						<hr>
						<div class="card-body">
							<div id="clickable1">
								<table id="VerifikasiIjin" data-width="100%" class="table table-bordered data-table mb-4">
										<thead>
											<tr>
												<!-- <th>Detail</th> -->
												<th>JENIS CUTI </th>
												<th>NO.DOK </th>
												<th>NAMA</th>
												<th>KETERANGAN</th>
												<th>TGL.DOK</th>
												<th class="empty">&nbsp;</th>
											</tr>
										</thead>
								</table>
							</div>
							<div id="table2">
									<div class="form-inline">
										<div class="input-group mb-2 mr-sm-2">
											<div class="input-group-prepend">
												<div class="input-group-text"><span class="search-icon"><i class="simple-icon-magnifier"></i></span></div>
											</div>
											<input type="text"  data-column="3" class="search-input-text form-control" placeholder="Search by Nama Lengkap">
										</div>
									</div>
								<table id="VerifikasiIjinHistory" data-width="100%" class="table table-bordered data-table mb-4">
									<thead>
										<tr>
											<!-- <th>Detail</th> -->
											<th>NO.DOK</th>
											<th>TGL DOK</th>
											<th>NIP</th>
											<th>NAMA LENGKAP</th>
											<th>DEPT</th>
											<th>KETERANGAN</th>
											<th>STATUS</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
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
				<p id="data_lampiran"></p>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary"
					data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script src="//code.jquery.com/jquery-2.2.0.min.js"></script>
<?php //echo $this->load->assets('ijin', 'verifikasi', 'js');  ?>

<script>
var VerifikasiIjin;
var VerifikasiIjinHistory;

$(document).ready(function() {

    VerifikasiIjin = $('#VerifikasiIjin').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        // "scrollY": "50vh",
        // "scrollCollapse": true,
        // "paging": false,

        'ajax': {
            'url': base_url + 'leaves/ijin/fetchDataVerifikasi',
            'type': 'POST',
        },
        "language": {
            "emptyTable": "There are no data."
        },
        'order': [0, 'DESC'],
        'columns': [
            // {
            //     'className': 'details-control',
            //     'data': null,
            //     'defaultContent': ''
            // },
            { 'data': [0], 'class': 'text-center' },
            { 'data': [1] },
            { 'data': [2] },
            { 'data': [3] },
            { 'data': [4] },
            { 'data': [5] },
            // { 'data': [6] },
            // { 'data': [7] },
        ],
    });
    $("#VerifikasiIjin_filter").css("display", "none"); // hiding global search box
    $('#VerifikasiIjin tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = VerifikasiIjin.row(tr);
        var row = VerifikasiIjin.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(tampil_detail(row.data())).show();
            tr.addClass('shown');
        }
    });

    VerifikasiIjinHistory = $('#VerifikasiIjinHistory').DataTable({
        'scrollX': true,
        'processing': true,
        'serverSide': true,
        'responsive': true,
        'ajax': {
            'url': base_url + 'leaves/ijin/fetchDataVerifikasiHistory',
            'type': 'POST',
        },
        'order': [2, 'DESC'],
        'columns': [
			// {
            //     'className': 'details-control',
            //     'data': null,
            //     'defaultContent': ''
            // },
            {
                'data': [0]
            },
            {
                'data': [1]
            },
            {
                'data': [2]
            },
            {
                'data': [3]
            },
            {
                'data': [4]
            },
            {
                'data': [5]
            },
            {
                'data': [6]
            },
        ],
    });
    $("#VerifikasiIjinHistory_filter").css("display", "none");
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            VerifikasiIjinHistory.columns(i).search(v).draw();
        }
    });
    $('#VerifikasiIjinHistory tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = ApprovalIjin.row(tr);
        var row = VerifikasiIjinHistory.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(tampil_detail_history(row.data())).show();
            tr.addClass('shown');
        }
    });



});

function tampil_detail(d) {
    // d is the original d object for the row var val;
    if (d.secondary.length == null) {
        return "There are no datas";
    }
    var display = '<table class="table-bordered" style="margin-left:70px;width:450px;">';

    display += '<thead>' +
        '<tr>' +
        '<th>TGL IJIN</th>' +
        '<th>HARI</th>' +
        '<th>KETERANGAN</th>' +
        '</tr>' +
        '</thead><tbody>';
    for (val of d.secondary) {
        console.log(val);
        display +=
            '<tr>' +
            '<td>' + val[0] + '</td>' +
            '<td>' + val[1] + '</td>' +
            '<td>' + val[2] + '</td></tr>';
    }
    display += '</tbody></table>';

    return display;
}


function tampil_detail_history(d) {
    // d is the original d object for the row var val;
    if (d.secondary.length == null) {
        return "There are no datas";
    }
    var display = ' <div class="row mb-3" style="margin-left:70px">' +
        '<div class="col-md-4">' +
        d.file1 +
        '</div>' +
        '<div class="col-md-4">' +
        d.file2 +
        '</div>' +
        '<div class="col-md-4">' +
        d.file3 +
        '</div>' +
        '</div> ' +
        '<table class="table-bordered" style="margin-left:70px;width:450px;">';
    display += '<thead><tr>' +
        '<th>TANGGAL</th>' +
        '<th>HARI</th>' +
        '<th>KETERANGAN</th>' +
        '</tr></thead><tbody>';
    for (val of d.secondary) {
        console.log();
        // var originalLog = console.log;
        // console.log = function(val) {
        //     originalLog(JSON.parse(JSON.stringify(val)));
        // };
        display +=
            '<tr>' +
            '<td>' + val[0] + '</td>' +
            '<td>' + val[1] + '</td>' +
            '<td>' + val[2] + '</td>' +
            '</tr>';
    }
    display += '</tbody></table>';

    return display;
}


function detail_doc_history(id) {
    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'leaves/ijin/detail_doc_history/' + id,
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
			textlampiran = "";
			var array = data;
			detailtem(array);
			detailapp(array);
			detaillampiran(array);
			document.getElementById("data_report").innerHTML = text;
			document.getElementById("data_approve").innerHTML = textapp;
			document.getElementById("data_lampiran").innerHTML = textlampiran;

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

function detaillampiran(array) {
		textlampiran += '<hr> <h5><b>Detail Lampiran</b></h5> <table class="table table-bordered data-table">';
		textlampiran += '<thead>' +
        '<tr>' +
        '<th>Lampiran 1</th>' +
		'<th>Lampiran 2</th>' +
        '<th>Lampiran 3</th>' +
        '</tr>' +
        '</thead><tbody>';
		for (val of array.lampiran) {
			console.log(val);
			textlampiran +=
				'<tr>' +
                    '<td>'+
                    '<a data-fancybox="gallery" data-src="' + base_url + 'upload/ijin/' + val[0]+ '" >' +
                        '<img width="100%" src="' + base_url + 'upload/ijin/' + val[0]+ '" />'+
                    '</a>'+
                        // '<a class="test-popup-link" target="_blank" href="' + base_url + 'upload/ijin/' + val[0]+ '">' +
                        //     '<img class="img-fluid border-radius"' +
                        //     'src="' + base_url + 'upload/ijin/' + val[0]+ '" /></a>' +
                    '</td>'+
					'<td>'+
                        '<a data-fancybox="gallery" data-src="' + base_url + 'upload/ijin/' + val[1]+ '" >' +
                            '<img width="100%" src="' + base_url + 'upload/ijin/' + val[1]+ '" />'+
                        '</a>'+
                    '</td>' +
					'<td>'+
                        '<a data-fancybox="gallery" data-src="' + base_url + 'upload/ijin/' + val[2]+ '" >' +
                            '<img width="100%" src="' + base_url + 'upload/ijin/' + val[2]+ '" />'+
                        '</a>'+
                    '</td>' +
                '</tr>';
		}
		textlampiran += '</tbody></table>';
};



</script>

