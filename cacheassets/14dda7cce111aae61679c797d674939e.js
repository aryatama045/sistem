var manageIjin;

$(document).ready(function() {
    // initialize the datatable
    manageIjin = $('#manageIjin').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/ijin/fetchDataCuti',
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

    $("#manageIjin_filter").css("display", "none");
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            manageIjin.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        manageIjin.columns(i).search(v).draw();
    });
});