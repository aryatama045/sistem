var tanggal1;
var tanggal2;
var tableAbsen;
var textitem;

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
        tableAbsen.ajax.reload();
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
                    html += '<option value=' + data[i].kd_store + '>' + data[i].kd_store + ' - ' + data[i].nama_store + '</option>';
                }
                $('#nm_store').html(html);
            }
        });
        tableAbsen.ajax.reload();
        return false;
    });

    $('#btn-pdf-action').click(function(e) {
        tanggal1 = $('[name=tanggal1]').val();
        tanggal2 = $('[name=tanggal2]').val();
        // alert(tanggal2);
        $('#action').val('print');
        $("#form-print").attr('target', 'new');
        $("#form-print").submit();
        e.preventDefault();
    });

    $('#btn-excel-action').click(function(e) {
        tanggal1 = $('[name=tanggal1]').val();
        tanggal2 = $('[name=tanggal2]').val();
        $('#action').val('excel');
        $("#form-print").removeAttr('target');
        $("#form-print").submit();
        e.preventDefault();
    });


    // initialize the datatable 
    tableAbsen = $('#tableAbsen').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/absensi_status/fetchDataAbsenStatus',
            'type': 'POST',
            'data': function(data) {
                data.nip = $('#nip').val();
                data.nama_lengkap = $('#nama_lengkap').val();
                data.status_absensi = $('#status_absensi').val();
                data.tanggal1 = $('#tanggal1').val();
                data.tanggal2 = $('#tanggal2').val();
                data.id_divisi = $('#nm_divisi').val();
                data.id_dept = $('#nm_departement').val();
                data.kd_store = $('#nm_store').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
                targets: 0,
                className: 'text-left'
            },
            // {
            //     targets: 1,
            //     className: 'text-center'
            // },
        ]
    });
    $("#tableAbsen_filter").css("display", "none");

    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            tableAbsen.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        tableAbsen.columns(i).search(v).draw();
    });

    $('#btn-tampil').click(function() { //button filter event click
        tableAbsen.ajax.reload(); //just reload table
    });

    $('#tanggal1').on('change', function() { //button filter event click
        tableAbsen.ajax.reload(); //just reload table
    });

    $('#tanggal2').on('change', function() { //button filter event click
        tableAbsen.ajax.reload(); //just reload table
    });

    $('#status_absensi').on('change', function() { //button filter event click
        tableAbsen.ajax.reload(); //just reload table
    });

    $('#nm_store').on('change', function() { //button filter event click
        tableAbsen.ajax.reload(); //just reload table
    });

    $('#nip').on('change', function() { //button filter event click
        tableAbsen.ajax.reload(); //just reload table
    });

    $('#nama_lengkap').on('change', function() { //button filter event click
        tableAbsen.ajax.reload(); //just reload table
    });


});

function detail_doc(id,tgl) {

    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'leaves/absensi_status/absen_history/' + id + '/' + tgl,
        type: "GET",
        dataType: "JSON",
        success: function(data) {

            $('#DetailReport').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Absen History - ' + id); // Set title to Bootstrap modal title

            textitem = "";
            var array = data;
            detailtem(array);
            document.getElementById("data_item").innerHTML = textitem;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
};

function detailtem(array) {
    textitem += '<table class="table table-bordered data-table">';
    textitem += '<thead>' +
    '<tr>' +
    '<th>Tanggal</th>' +
    '<th>Jenis</th>' +
    '<th>Waktu</th>' +
    '<th>Lokasi</th>' +
    '</tr>' +
    '</thead><tbody>';
    for (val of array.data) {
        console.log(val);
        textitem +=
            '<tr>' +
            '<td>' + val[0] + '</td>' +
            '<td>' + val[1] + '</td>' +
            '<td>' + val[2] + '</td>' +
            '<td>' + val[3] + '</td></tr>';
    }
    textitem += '</tbody></table>';
};