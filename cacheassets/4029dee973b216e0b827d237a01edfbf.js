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
        'columnDefs': [{
            targets: 0,
            className: 'text-left'
        }, ]

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