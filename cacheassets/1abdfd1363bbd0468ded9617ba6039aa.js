var manageTableCutiTambahan;

$(document).ready(function() {
    // initialize the datatable 

    manageTableCutiTambahan = $('#manageTableCutiTambahan').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/cuti_tambahan/getPengajuanCutiTambahanAll',
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
            { 'data': [7] },
            { 'data': [8] },
            { 'data': [9] },
            { 'data': [10] },
        ],
    });
    $('#manageTableCutiTambahan tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = manageTableCutiTambahan.row(tr);
        var row = manageTableCutiTambahan.row(tr);

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
});


function tampil_detail(d) {
    // d is the original d object for the row var val;
    if (d.secondary.length == null) {
        return "There are no datas";
    }
    var display = '<table class="table-bordered" style="margin-left:70px;width:auto;">';

    display += '<thead>' +
        '<tr>' +
        '<th>App 1</th>' +
        '<th>App 2</th>' +
        '<th>App 3</th>' +

        '<th>Ket. Rej 1</th>' +
        '<th>Ket. Rej 2</th>' +
        '<th>Ket. Rej 3</th>' +
        '</tr>' +
        '</thead><tbody>';
    // for (val of d.secondary) {
    console.log(d.secondary);
    display +=
        '<tr>' +
        '<td>' + d.secondary[0] + '</td>' +
        '<td>' + d.secondary[1] + '</td>' +
        '<td>' + d.secondary[2] + '</td>' +

        '<td>' + d.secondary[3] + '</td>' +
        '<td>' + d.secondary[4] + '</td>' +
        '<td>' + d.secondary[5] + '</td>' +
        '</tr>';
    // }
    display += '</tbody></table>';

    return display;
}