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
        'columns': [{
                'className': 'details-control',
                'data': null,
                'defaultContent': ''
            },
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