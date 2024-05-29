var tableTa;
var tahun_ajaran;

$(document).ready(function() {

    //# initialize the datatable
    tableTa = $('#tableTa').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'paging' : true,
        'autoWidth': false,
        'destroy': true,
        'responsive': false,
        'ajax': {
            'url': base_url + 'master/tahun_ajaran/store',
            'type': 'POST',
            'data': function(data) {
                data.tahun_ajaran = $('#tahun_ajaran').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
            bSortable: false
        }, ]
    });

    $("#tableTa_filter").css("display", "none");
    // $("#tableTa_length").css("display", "none");

    tableTa.columns.adjust().draw();

    $('#tahun_ajaran').on('keyup', function(event) { // for text boxes
        tableTa.ajax.reload(); //just reload table
    });
});