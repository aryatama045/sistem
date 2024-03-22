var manageApproval;
var manageApprovalCutiPengganti;
$(document).ready(function() {


    manageApproval = $('#manageApproval').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/cuti_tambahan/fetchDataApproval',
            'type': 'POST',
        },
        'order': [0, 'DESC'],

    });
    $("#manageApproval_filter").css("display", "none"); // hiding global search box

    manageHistoryCutiPengganti = $('#manageHistoryCutiPengganti').DataTable({
        'processing': true,
        'serverSide': true,
        'scrollX': true,
        'ajax': {
            'url': base_url + 'leaves/cuti_tambahan/getHistoryCutiPengganti',
            'type': 'POST',
        },
        'order': [0, 'DESC'],
        'columns': [{
                'data': [0]
            },
            {
                'data': [1]
            },
            {
                'data': [2]
            },
            {
                'data': [3]
            },
            {
                'data': [4]
            },
            {
                'data': [5]
            },
            {
                'data': [6]
            },
            {
                'data': [7]
            },
            // {
            //     'data': [8]
            // },
        ],
    });

    $("#manageHistoryCutiPengganti_filter").css("display", "none"); // hiding global search box
    $('.search-input-text').on('keyup', function(event) { // for text boxes
        var i = $(this).attr('data-column'); // getting column index
        var v = $(this).val(); // getting search input value
        var keycode = event.which;
        if (keycode == 13) {
            manageHistoryCutiPengganti.columns(i).search(v).draw();
        }
    });


});