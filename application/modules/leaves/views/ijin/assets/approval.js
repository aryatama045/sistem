var ApprovalIjin;
var ApprovalIjinHistory;
$(document).ready(function() {


    ApprovalIjin = $('#ApprovalIjin').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/ijin/fetchDataApproval',
            'type': 'POST',
        },
        'order': [0, 'DESC'],
        'columns': [{
                'className': 'details-control',
                'data': null,
                'defaultContent': ''
            },
            { 'data': [1] },
            { 'data': [2] },
            { 'data': [3] },
            { 'data': [4] },
            { 'data': [5] },
        ],
    });
    $("#ApprovalIjin_filter").css("display", "none"); // hiding global search box
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            ApprovalIjin.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        ApprovalIjin.columns(i).search(v).draw();
    });
    $('#ApprovalIjin tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = ApprovalIjin.row(tr);
        var row = ApprovalIjin.row(tr);

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


    ApprovalIjinHistory = $('#ApprovalIjinHistory').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        'ajax': {
            'url': base_url + 'leaves/ijin/fetchDataApprovalHistory',
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
    $("#ApprovalIjinHistory_filter").css("display", "none");
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            ApprovalIjinHistory.columns(i).search(v).draw();
        }
    });
    $('#ApprovalIjinHistory tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = ApprovalIjin.row(tr);
        var row = ApprovalIjinHistory.row(tr);

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
    var display = '<table class="table-bordered" style="margin-left:70px;width:450px;">';
    // tgl_tdk_masuk, jam_ijin, jam_kembali, nilai_hari, nama_hari, potong_cuti_dari,KETERANGAN
    display += '<thead>' +
        '<tr>' +
        '<th>HARI</th>' +
        '<th>TANGGAL</th>' +
        '<th>JAM IJIN</th>' +
        '<th>JAM KEMBALI</th>' +
        '<th>POTONG CUTI</th>' +
        '<th>KETERANGAN</th>' +
        '<th>LAMPIRAN 1</th>' +
        '<th>LAMPIRAN 2</th>' +
        '<th>LAMPIRAN 3</th>' +
        '</tr>' +
        '</thead><tbody>';
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
            '<td>' + val[3] + '</td>' +
            '<td>' + val[4] + '</td>' +
            '<td>' + val[5] + '</td>' +
            '<td>' + val[6] + ' </td>' +
            '<td>' + val[7] + '</td>' +
            '<td>' + val[8] + '</td>' +
            '</tr>';
    }
    display += '</tbody></table>';

    return display;
}