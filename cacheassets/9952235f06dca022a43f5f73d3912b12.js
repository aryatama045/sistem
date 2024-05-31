var tables;
var search_name;

$(document).ready(function() {

    //# initialize the datatable
    tables = $('#'+tableData).DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'paging' : true,
        'autoWidth': false,
        'destroy': true,
        'responsive': false,
        'ajax': {
            'url': linkstore,
            'type': 'POST',
            'data': function(data) {
                data.search_name = $('#search_name').val();
            },
        },
        'order': [0, 'ASC'],
        "columnDefs":[
            {"orderData": 3, "targets": 2},
            {"visible": false, "targets":3}]
    });

    $("#"+tableData+"_filter").css("display", "none");
    // $("#tables_length").css("display", "none");

    tables.columns.adjust().draw();

    $('#search_name').on('keyup', function(event) { // for text boxes
        tables.ajax.reload(); //just reload table
    });
});