var manageApproval;
var manageCutiDispensasi;
$(document).ready(function() {

    manageApproval = $('#manageApproval').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/cuti_dispensasi/fetchDataApproval',
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
            { 'data': [6] },
        ],
    });
    $("#manageApproval_filter").css("display", "none"); // hiding global search box

    $('#manageApproval tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = manageApproval.row(tr);
        var row = manageApproval.row(tr);

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

    manageCutiDispensasi = $('#manageCutiDispensasi').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/cuti_dispensasi/fetchCutiDispensasi',
            'type': 'POST',
        },
        'order': [0, 'DESC'],
        'columns': [{
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
            {
                'data': [7]
            },
        ],
    });
    $("#manageCutiDispensasi_filter").css("display", "none"); // hiding global search box
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            manageCutiDispensasi.columns(i).search(v).draw();
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
        '<th>TGL CUTI</th>' +
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
