var tableApprove;
var limit_rows = 110;
var page = 1;

$(document).ready(function() {
    $('#pic_approve').select2({
        placeholder: ' --- SELECT Karyawan --- ',
        theme: "bootstrap",
        tags: true,
        // dropdownParent: $("#pic_approve"),
        ajax: {
            url: base_url + 'user/approve/get_data_karyawan',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    pic: params.term
                };
            },
            processResults: function(data) {

                var results = [];
                $.each(data.items, function(index, item) {
                    results.push({
                        id: item.biodata_id,
                        text: item.nip + '-' + item.nama_lengkap
                    });
                });

                return {
                    results: results
                };

            },
            cache: true
        }
    });

    $('#district').select2({
        placeholder: '--- Select District---',
        ajax: {
            url: base_url + 'user/approve/get_data_karyawan',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page_limit: limit_rows,
                    page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                var results = [];
                $.each(data.items, function(index, item) {
                    results.push({
                        id: item.biodata_id,
                        text: item.nip + '-' + item.nama_lengkap
                    });
                });
                return {
                    // results: data.items,
                    results: results,
                    pagination: {
                        more: (params.page * limit_rows) < data.total
                    }
                };
            },
            cache: false
        }
    });

    $('#karyawan').change(function() {
        var id = $('[name=karyawan]').val();
        // alert(id);
        $.ajax({
            url: base_url + 'user/approve/get_karyawan',
            method: "POST",
            data: { id: id },
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                html += '<input disabled value=' + data.kd_store + ' name="kd_store" class="form-control" >';
                $('#kd_store').html(html);
            }
        });
        tableApprove.ajax.reload();
        return false;
    });

    //# initialize the datatable
    tableApprove = $('#tableApprove').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'ajax': {
            'url': base_url + 'user/approve/fetchDataApproveCP',
            'type': 'POST',
            'data': function(data) {
                data.karyawan = $('#karyawan').val();
                data.kd_store = $('#kd_store').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
            targets: 0,
            className: 'text-left'
        }, ]
    });
    $("#tableApprove_filter").css("display", "none");
    $("#tableApprove_paginate").css("display", "none");
    $("#tableApprove_length").css("display", "none");
    $("#tableApprove_info").css("display", "none");

    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            tableApprove.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        tableAbsen.columns(i).search(v).draw();
    });

    $('#karyawan').on('change', function() { //button filter event click
        tableApprove.ajax.reload(); //just reload table
    });
});

function edit_person(id) {
    var biodata_id = $('[name=karyawan]').val();
    // alert(biodata_id);
    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'user/approve/get_pic_app_cp',
        method: "POST",
        data: {
            id: id,
            biodata_id: biodata_id
        },
        async: true,
        dataType: 'json',
        success: function(data) {

            // $('[name="nama_app"]').val(data.nama_app);
            $('[name="biodata_karyawan"]').val(data.biodata_id);
            $('.select-app').val(data.id_app).text(data.nip_app + ' - ' + data.nama_app);
            $('[name="app_urutan"]').val(data.urutan_app);
            $('#editModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('PIC APP ' + data.urutan_app + ' (' + data.nip_app + ') ' + data.nama_app); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
};


function remove_pic(id) {
    var biodata_id = $('[name=karyawan]').val();
    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'user/approve/get_pic_app_cp',
        method: "POST",
        data: { id: id, biodata_id: biodata_id },
        async: true,
        dataType: 'json',
        success: function(data) {

            $('[name="id_karyawan"]').val(data.nip_user);
            $('[name="id_karyawan_pic"]').val(data.nip_app);
            $('[name="pic_urutan"]').val(data.urutan_app);
            $('#removeModal').modal('show'); // show bootstrap modal when complete loaded
            $('.data-content').text('(' + data.nip_app + ') ' + data.nama_app); // Set title to Bootstrap modal title
            $('.modal-title').text('PIC APP REMOVE'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
};