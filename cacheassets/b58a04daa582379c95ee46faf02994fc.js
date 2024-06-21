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
                data.search_prodi =$('input[name=search_prodi]:checked' ).val();
                data.search_dosen = $('input[name=search_dosen]:checked' ).val();
            },
        },
        'order': [1, 'ASC'],
        "columnDefs":[
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

    $('#prodi').on('change', function(){ //button filter event click
        tables.ajax.reload();  //just reload table
    });

    $('input[name=search_dosen]').change(function(){
        var value = $( 'input[name=search_dosen]:checked' ).val();
        tables.ajax.reload();  //just reload table
    });

    $('input[name=search_prodi]').change(function(){
        var value = $( 'input[name=search_prodi]:checked' ).val();
        tables.ajax.reload();  //just reload table
    });
});
