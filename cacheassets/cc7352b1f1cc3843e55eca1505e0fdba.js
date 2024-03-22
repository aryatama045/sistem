var TableDetailKas;

$(document).ready(function() {
    // initialize the datatable
    TableDetailKas = $('#TableDetailKas').DataTable({
        'processing': true,
        'scrollX': true,
    });

    $("#TableDetailKas_filter").css("display", "none");
    $("#TableDetailKas_length").css("display", "none");
    $("#TableDetailKas_paginate").css("display", "none");
    $("#TableDetailKas_info").css("display", "none");

});
