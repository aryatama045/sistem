var tableKaryawan;
var nip;
var nama_lengkap;

$(document).ready(function() {

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
        tableKaryawan.ajax.reload();
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
        tableKaryawan.ajax.reload();
        return false;
    });

    //# initialize the datatable
    tableKaryawan = $('#tableKaryawan').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'ajax': {
            'url': base_url + 'user/karyawan/fetchDataKaryawan',
            'type': 'POST',
            'data': function(data) {
                data.nip = $('#nip').val();
                data.nama_lengkap = $('#nama_lengkap').val();
                data.id_divisi = $('#nm_divisi').val();
                data.id_dept = $('#nm_departement').val();
                data.kd_store = $('#nm_store').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
            targets: 0,
            className: 'text-left'
        }, ]
    });

    $("#tableKaryawan_filter").css("display", "none");

    $('#nip').on('keyup', function(event) { // for text boxes
        tableKaryawan.ajax.reload(); //just reload table
    });

    $('#nama_lengkap').on('keyup', function(event) { // for text boxes
        tableKaryawan.ajax.reload(); //just reload table
    });


});