var tableJenisBiaya;
var kd_jenis;
var nama_biaya;

$(document).ready(function() {

    $('.collapse').on('shown.bs.collapse', function (e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });



    //# initialize the datatable
    tableJenisBiaya = $('#tableJenisBiaya').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'paging' : true,
        'ajax': {
            'url': base_url + 'master/biaya/getDataStoreJenis',
            'type': 'POST',
            'data': function(data) {
                data.kd_jenis = $('#kd_jenis').val();
                data.nama_biaya = $('#nama_biaya').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
            bSortable: false
        }, ]
    });

    $("#tableJenisBiaya_filter").css("display", "none");
    $("#tableJenisBiaya_length").css("display", "none");

    tableJenisBiaya.columns.adjust().draw();

    $('#kd_jenis').on('keyup', function(event) { // for text boxes
        tableJenisBiaya.ajax.reload(); //just reload table
    });

    $('#nama_biaya').on('keyup', function(event) { // for text boxes
        tableJenisBiaya.ajax.reload(); //just reload table
    });


});