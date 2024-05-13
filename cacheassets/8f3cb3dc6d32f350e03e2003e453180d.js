var tableBiaya;
var kd_biaya;
var nilai;

$(document).ready(function() {

    $('.collapse').on('shown.bs.collapse', function (e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });



    //# initialize the datatable
    tableBiaya = $('#tableBiaya').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'paging' : true,
        'ajax': {
            'url': base_url + 'master/biaya/getDataStore',
            'type': 'POST',
            'data': function(data) {
                data.kd_biaya = $('#kd_biaya').val();
                data.nilai = $('#nilai').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
            bSortable: false
        }, ]
    });

    $("#tableBiaya_filter").css("display", "none");
    $("#tableBiaya_length").css("display", "none");

    tableBiaya.columns.adjust().draw();

    $('#kd_biaya').on('keyup', function(event) { // for text boxes
        tableBiaya.ajax.reload(); //just reload table
    });

    $('#nilai').on('keyup', function(event) { // for text boxes
        tableBiaya.ajax.reload(); //just reload table
    });


});