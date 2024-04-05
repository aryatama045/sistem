var tableMahasiswa;
var nim;
var nama_mhs;

$(document).ready(function() {

    $('.collapse').on('shown.bs.collapse', function (e) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
    });


    $('#nm_divisi').change(function() {
        var id = $('[name=nm_divisi]').val();
        // alert(id);
        $.ajax({
            url: base_url + 'leaves/absensi_status/get_data_departement',
            method: "POST",
            data: { id: id },
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;
                html += '<option value="">--PILIH DEPARTMENT--</option>';
                for (i = 0; i < data.length; i++) {
                    // alert(data[i].dept_id);
                    html += '<option value=' + data[i].dept_id + '>' + data[i].nama_dept + '</option>';
                }
                $('#nm_departement').html(html);
            }
        });
        tableMahasiswa.ajax.reload();
        return false;
    });


    $('#nm_departement').change(function() {
        var id = $('[name=nm_departement]').val();
        var divisi_id = $('[name=nm_divisi]').val();
        // alert(divisi_id);
        $.ajax({
            url: base_url + 'leaves/absensi_status/get_data_store',
            method: "POST",
            data: { id: id, divisi_id: divisi_id },
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;
                html += '<option value="">--PILIH STORE--</option>';
                for (i = 0; i < data.length; i++) {
                    // alert(data[i].dept_id);
                    html += '<option value=' + data[i].kd_store + '>' + data[i].nama_store + '</option>';
                }
                $('#nm_store').html(html);
            }
        });
        tableMahasiswa.ajax.reload();
        return false;
    });

    //# initialize the datatable
    tableMahasiswa = $('#tableMahasiswa').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'paging' : true,
        'ajax': {
            'url': base_url + 'users/mahasiswa/getDataStore',
            'type': 'POST',
            'data': function(data) {
                data.nim = $('#nim').val();
                data.nama_mhs = $('#nama_mhs').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
            bSortable: false
        }, ]
    });

    $("#tableMahasiswa_filter").css("display", "none");
    $("#tableMahasiswa_length").css("display", "none");

    $('#nim').on('keyup', function(event) { // for text boxes
        tableMahasiswa.ajax.reload(); //just reload table
    });

    $('#nama_mhs').on('keyup', function(event) { // for text boxes
        tableMahasiswa.ajax.reload(); //just reload table
    });


});