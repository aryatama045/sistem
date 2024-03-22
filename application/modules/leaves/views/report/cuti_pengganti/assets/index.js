var tanggal1;
var tanggal2;

$(document).ready(function(){

    $(".select2-single").select2({
        placeholder: " ",
        allowClear: true,
        width: '100%',
        escapeMarkup: function (markup) { return markup; },
        language: {
            noResults: function () {
                return "Not Found Result" + " - " + " <a href='" + base_url +"master/supplier_customer/create' target='_blank'>Create</a>";
            }
        }
    });

    $('#nm_divisi').change(function(){
        $('#nm_departement').prop('selectedIndex',0);
        $('#nm_store').prop('selectedIndex',0);
    });
    $('#nm_departement').change(function(){
        $('#nm_store').prop('selectedIndex',0);
    });

    $('#nm_divisi').change(function(){
        var id = $('[name=nm_divisi]').val();
        // alert(id);
        $.ajax({
        url : base_url+"leaves/report/get_data_departement",
        method : "POST",
        data : {id: id},
        async : true,
        dataType : 'json',
        success: function(data){
            var html = '';
            var i;
            html += '<option value="">--PILIH DEPARTMENT--</option>';
            for(i=0; i<data.length; i++){
                // alert(data[i].dept_id);
                html += '<option value='+data[i].dept_id+'>'+data[i].nama_dept+'</option>';
            }
            $('#nm_departement').html(html);
        }
        });
        dataTable.ajax.reload();
        return false;
    });

    $('#nm_departement').change(function(){
        var id = $('[name=nm_departement]').val();
        var divisi_id = $('[name=nm_divisi]').val();
        // alert(divisi_id);
        $.ajax({
        url : base_url+"leaves/report/get_data_store",
        method : "POST",
        data : {id: id,divisi_id: divisi_id},
        async : true,
        dataType : 'json',
        success: function(data){
            var html = '';
            var i;
            html += '<option value="">--PILIH STORE--</option>';
            for(i=0; i<data.length; i++){
                // alert(data[i].dept_id);
                html += '<option value='+data[i].kd_store+'>' +data[i].kd_store+' - '+data[i].nama_store+'</option>';
            }
            $('#nm_store').html(html);
        }
        });
        dataTable.ajax.reload();
        return false;
    });

    $('#btn-pdf-action').click(function (e) {
            tanggal1 = $('[name=tanggal1]').val();
            tanggal2 = $('[name=tanggal2]').val();
            // alert(tanggal2);
        $('#action').val('print');
        $("#form-print").attr('target', 'new');
        $("#form-print").submit();
        e.preventDefault();
    });

    $('#btn-excel-action').click(function (e) {
        tanggal1 = $('[name=tanggal1]').val();
        tanggal2 = $('[name=tanggal2]').val();
    $('#action').val('excel');
    $("#form-print").removeAttr('target');
    $("#form-print").submit();
    e.preventDefault();
    });

    // initialize the datatable
    dataTable = $('#dataTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/report/fetchCutiPengganti',
            'type': 'POST',
                'data':function(data) {
                    data.karyawan = $('#karyawan').val();
                    data.tanggal1 = $('#tanggal1').val();
                    data.tanggal2 = $('#tanggal2').val();
                    data.id_divisi = $('#nm_divisi').val();
                    data.id_dept = $('#nm_departement').val();
                    data.kd_store = $('#nm_store').val();
                },
        },
        'order': [0, 'ASC'],
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
        ],
    });
    $('#dataTable tbody').on('click', 'tr td.details-control', function() {
        var tr = $(this).closest('tr');
        // var row = dataTable.row(tr);
        var row = dataTable.row(tr);

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

    $("#dataTable_filter").css("display", "none");

    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            dataTable.columns(i).search(v).draw();
        }
    });

    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        dataTable.columns(i).search(v).draw();
    });

    $('#btn-tampil').click(function(){ //button filter event click
        dataTable.ajax.reload();  //just reload table
    });

    $('#tanggal1').on('change', function(){ //button filter event click
        dataTable.ajax.reload();  //just reload table
    });

    $('#tanggal2').on('change', function(){ //button filter event click
        dataTable.ajax.reload();  //just reload table
    });

    $('#nm_store').on('change', function(){ //button filter event click
        dataTable.ajax.reload();  //just reload table
    });

    $('#karyawan').on('change', function() { //button filter event click
        dataTable.ajax.reload(); //just reload table
    });



});



function tampil_detail(d) {
    // d is the original d object for the row var val;
    if (d.secondary.length == null) {
        return "Tidak ada data";
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