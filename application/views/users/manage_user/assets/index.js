var manageTable;
alert('tes');
$(document).ready(function() {

    // initialize the datatable
    manageTable = $('#manageTable').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/cuti/fetchDataCuti',
            'type': 'POST',
        },
        'order': [0, 'DESC'],
        'columnDefs': [{
                targets: 0,
                className: 'text-left'
            },
            {
                targets: 1,
                className: 'text-center'
            },
        ]
    });
    $("#manageTable_filter").css("display", "none");

    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            manageTable.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        manageTable.columns(i).search(v).draw();
    });

});

function edit_person(id) {
    //Ajax Load data from ajax
    $.ajax({
        url: base_url + 'leaves/cuti/get_no_doc/' + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {

            $('[name="no_dok_tdk_masuk"]').val(data.no_dok_tdk_masuk);
            $('#exampleModal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
};