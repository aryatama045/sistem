var manageTableCutiTambahan;

$(document).ready(function() {
// initialize the datatable 
manageTableCutiTambahan = $('#manageTableCutiTambahan').DataTable({
    // 'orderCellsTop': true,
    // 'fixedHeader': true,
    'processing': true,
    'serverSide': true,
    'scrollX': true,
    'ajax': {
        'url': base_url + 'leaves/cuti_tambahan/getPengajuanCutiTambahanAll',
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
});