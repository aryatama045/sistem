var manageOvertime;

$(document).ready(function() {
    // initialize the datatable
    manageOvertime = $('#manageOvertime').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/overtime/fetchDataApproval',
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

    $("#manageOvertime_filter").css("display", "none");
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            manageOvertime.columns(i).search(v).draw();
        }
    });
    $('.search-input-select').on('change', function() { // for select box
        var i = $(this).attr('data-column');
        var v = $(this).val();
        manageOvertime.columns(i).search(v).draw();
    });
});