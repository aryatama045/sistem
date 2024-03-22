var manageKas,manageHistory;
var text,textapp;

$(document).ready(function() {
    // initialize the datatable
    manageKas = $('#manageKas').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/berita_acara/fetchDataApproval',
            'type': 'POST',
        },
        'order': [0, 'DESC'],
        'columnDefs': [{
            targets: 0,
            className: 'text-left'
        }, ]
    });

    $("#manageKas_filter").css("display", "none");
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            manageKas.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        manageKas.columns(i).search(v).draw();
    });

    manageHistory = $('#manageHistory').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/berita_acara/fetchDataHistoryDept',
            'type': 'POST',
        },
        'order': [0, 'DESC'],
        'column': [{
            targets: 0,
            className: 'text-left',
            width:'20px'
        }, ]
    });
    $("#manageHistory_filter").css("display", "none"); // hiding global search box
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            manageHistory.columns(i).search(v).draw();
        }
    });
});

function detail(id) {
    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'leaves/berita_acara/get_history/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {

            $('#DetailReport').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Detail - ' + id); // Set title to Bootstrap modal title
            header_report ="";
            header_report += '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> NO REQUEST</label>' +
                '<div class="col-sm-8"> : <b>' + data.no_request + '</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> JENIS</label>' +
                '<div class="col-sm-8"> : <b>' + data.jenis + '</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> TGL. DOC</label>' +
                '<div class="col-sm-8"> : <b>' + data.tgl_request + '</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> NAMA REQ.</label>' +
                '<div class="col-sm-8"> : <b>' + data.nip +'</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> DEPT REQ.</label>' +
                '<div class="col-sm-8"> : <b>' + data.dept +'</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> BIAYA SEBELUMNYA</label>' +
                '<div class="col-sm-8"> : <b>' + data.total_biaya_sebelumnya + '</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> TOTAL BIAYA</label>' +
                '<div class="col-sm-8"> : <b>' + data.total_biaya + '</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> TOTAL UANG MUKA</label>' +
                '<div class="col-sm-8"> : <b>' + data.total_um + '</b></div> </div>' +

                '<div class="form-group row">' +
                '<label class="col-sm-4 col-form-label"> KETERANGAN</label>' +
                '<div class="col-sm-8"> : <b>' + data.keterangan + '</b></div> </div>'
            ;
            document.getElementById("header_report").innerHTML = header_report;

            text = "";
            var array = data;
            detailtem(array);
            document.getElementById("data_report").innerHTML = text;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
};

function detailtem(array) {
    text += '<hr> <h5><b>Detail</b></h5> <table class="table table-bordered data-table" width="100%">';
    text += '<thead>' +
    '<tr>' +
    '<th>Kode Biaya</th>' +
    '<th>Biaya</th>' +
    '<th>Keterangan</th>' +
    '<th>Qty</th>' +
    '<th>Satuan</th>' +
    '<th>Harga Satuan</th>' +
    '<th>Total</th>' +
    '</tr>' +
    '</thead><tbody>';
    for (val of array.data) {
        console.log(val);
        text +=
            '<tr>' +
            '<td>' + val[0] + '</td>' +
            '<td>' + val[1] + '</td>' +
            '<td>' + val[2] + '</td>' +
            '<td>' + val[3] + '</td>' +
            '<td>' + val[4] + '</td>' +
            '<td>' + val[5] + '</td>' +
            '<td>' + val[6] + '</td></tr>';
    }
    text += '</tbody>' +
    '<tfoot>' +
    '<tr>' +
    '<th colspan="6" style="text-align:center !important;">Grand Total</th>' +
    '<th>' + array.total_detail +'</th>' +
    '</tr>' +
    '</tfoot>' +
    '</table>';
};


function reject(id) {
    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'leaves/berita_acara/get_request/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {

            $('[name="no_request"]').val(data.no_request);
            $('[name="nama_req"]').val(data.nama_req);
            $('#rejectModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Reject Request'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
};