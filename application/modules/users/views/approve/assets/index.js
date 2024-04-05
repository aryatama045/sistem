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
        // 'paging': false,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'ajax': {
            'url': base_url + 'user/approve/fetchDataApprove',
            'type': 'POST',
            'data': function(data) {
                data.karyawan = $('#karyawan').val();
                data.kd_store = $('#kd_store').val();
            },
        },
        'order': [0, 'ASC'],
        'columnDefs': [{
            targets: 0,
            className: 'text-left',
            width: '20%',
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
    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'user/approve/get_pic_app',
        method: "POST",
        data: { id: id, biodata_id: biodata_id },
        async: true,
        dataType: 'json',
        success: function(data) {

            $('[name="nama_app"]').val(data.nama_app);
            $('[name="biodata_karyawan"]').val(data.biodata_id);
            $('.select-app').val(data.id_app).text(data.nip_app + ' - ' + data.nama_app);
            $('[name="app_urutan"]').val(data.urutan_approval);
            $('#editModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('PIC APP ' + data.urutan_approval + ' (' + data.nip_app + ') ' + data.nama_app); // Set title to Bootstrap modal title

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
        url: base_url + 'user/approve/get_pic_app',
        method: "POST",
        data: { id: id, biodata_id: biodata_id },
        async: true,
        dataType: 'json',
        success: function(data) {

            $('[name="id_karyawan"]').val(data.k_user);
            $('[name="id_karyawan_pic"]').val(data.k_pic);
            $('[name="biodata_user"]').val(data.biodata_id);
            $('[name="biodata_pic"]').val(data.id_app);
            $('[name="pic_urutan"]').val(data.urutan_approval);
            $('#removeModal').modal('show'); // show bootstrap modal when complete loaded
            $('.data-content').text('(' + data.nip_app + ') ' + data.nama_app); // Set title to Bootstrap modal title
            $('.modal-title').text('PIC APP REMOVE'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
};


// Function to shuffle the demo data
function shuffle(str) {
    return str
        .split('')
        .sort(function() {
            return 0.5 - Math.random();
        })
        .join('');
}

// For demonstration purposes we first make
// a huge array of demo data (20 000 items)
// HEADS UP; for the _.map function i use underscore (actually lo-dash) here
function mockData() {
    return _.map(_.range(1, 101), function(i) {
        return {
            id: i,
            text: shuffle('te ststr ing to shuffle') + ' ' + i,
        };
    });
}


(function() {
    // init select 2
    $('#test').select2({
        data: base_url + 'user/approve/get_pic_approve',
        placeholder: 'search',
        multiple: true,
        // query with pagination
        query: function(q) {
            var pageSize,
                results,
                that = this;
            pageSize = 20; // or whatever pagesize
            results = [];
            if (q.term && q.term !== '') {
                // HEADS UP; for the _.filter function i use underscore (actually lo-dash) here
                results = _.filter(that.data, function(e) {
                    return e.text.toUpperCase().indexOf(q.term.toUpperCase()) >= 0;
                });
            } else if (q.term === '') {
                results = that.data;
            }
            q.callback({
                results: results.slice((q.page - 1) * pageSize, q.page * pageSize),
                more: results.length >= q.page * pageSize,
            });
        },
    });
});