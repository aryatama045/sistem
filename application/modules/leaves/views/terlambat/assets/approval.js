var ApprovalTerlambat;
var ApprovalTerlambatHistory;
$(document).ready(function() {


    ApprovalTerlambat = $('#ApprovalTerlambat').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/terlambat/fetchDataApproval',
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
            // { 'data': [6] },
            // { 'data': [7] },
        ],
    });
    $("#ApprovalTerlambat_filter").css("display", "none"); // hiding global search box
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            ApprovalTerlambat.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        ApprovalTerlambat.columns(i).search(v).draw();
    });
    $('#ApprovalTerlambat tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = ApprovalTerlambat.row(tr);
        var row = ApprovalTerlambat.row(tr);

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


    ApprovalTerlambatHistory = $('#ApprovalTerlambatHistory').DataTable({
        'processing': true,
        'serverSide': true,
        'responsive': true,
        'ajax': {
            'url': base_url + 'leaves/terlambat/fetchDataApprovalHistory',
            'type': 'POST',
        },
        'order': [0, 'DESC'],
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
    $("#ApprovalTerlambatHistory_filter").css("display", "none");
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            ApprovalTerlambatHistory.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        ApprovalTerlambatHistory.columns(i).search(v).draw();
    });
    $('#ApprovalTerlambatHistory tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = ApprovalTerlambat.row(tr);
        var row = ApprovalTerlambatHistory.row(tr);

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
    // tgl_tdk_masuk, jam_terlambat, jam_kembali, nilai_hari, nama_hari, potong_cuti_dari,KETERANGAN
    display += '<thead>' +
        '<tr>' +
        '<th>HARI</th>' +
        '<th>TANGGAL</th>' +
        '<th>JAM IJIN</th>' +
        '<th>JAM KEMBALI</th>' +
        '<th>POTONG CUTI</th>' +
        '<th>KETERANGAN</th>' +
        '</tr>' +
        '</thead><tbody>';
    for (val of d.secondary) {
        console.log(val);
        display +=
            '<tr>' +
            '<td>' + val[0] + '</td>' +
            '<td>' + val[1] + '</td>' +
            '<td>' + val[2] + '</td>' +
            '<td>' + val[3] + '</td>' +
            '<td>' + val[4] + '</td>' +
            '<td>' + val[5] + '</td>' +
            '</tr>';
    }
    display += '</tbody></table>';

    return display;
}