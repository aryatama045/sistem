var tables;
var search_name;

$(document).ready(function() {
    //# initialize the datatable
    tables = $('#'+tableData).DataTable({
        'processing': true,
        'serverSide': true,
        'stateSave': true,
        'scrollX': true,
        'ajax': {
            'url': linkstore,
            'type': 'POST',
            'data': function(data) {
                data.search_name = $('#search_name').val();
                data.search_role = $('input[name=search_role]:checked' ).val();
            },
        },
        'order': [1, 'ASC'],
        'columnDefs':[
            {"orderData": 1, "targets": 1}]
    });


    $("#"+tableData+"_filter").css("display", "none");
    $("#"+tableData+"_length").css("display", "none");
    $("#"+tableData+"_info").css("display", "none");
    $("#"+tableData+"_paginate").css("display", "none");

    tables.columns.adjust().draw();

    $('#search_name').on('keyup', function(event) { // for text boxes
        tables.ajax.reload(); //just reload table
    });

    $('input[name=search_role]').change(function(){
        tables.ajax.reload();  //just reload table
    });


    var checkBox;
    var thisText;

    $('#selectAll').click(function () {
        thisText = $(this).text();
        if(thisText === "Unselect All"){
            $('input[type="checkbox"]')
            .attr('checked', false);
            $(this).text('Select All');
        }else{
            $('input[type="checkbox"]')
            .attr('checked', true);
            $(this).text('Unselect All');
        }
    });

}); // END Document Ready
