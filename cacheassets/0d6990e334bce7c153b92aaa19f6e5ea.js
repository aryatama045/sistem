var manageApproval;

$(document).ready(function() {
    manageApproval = $('#manageApproval').DataTable({
        // 'orderCellsTop': true,
        // 'fixedHeader': true,
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/leave/fetchDataApproval',
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
    $("#manageApproval_filter").css("display", "none");


});
