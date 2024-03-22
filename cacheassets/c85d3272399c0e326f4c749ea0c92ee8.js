var tableAbsen;
$(document).ready(function() {
    // initialize the datatable
    tableAbsen = $('#tableAbsen').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/report/fetchDataAbsen',
            'type': 'POST',
            'data': function(data) {
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
            {
                targets: 1,
                className: 'text-left'
            },
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

});
