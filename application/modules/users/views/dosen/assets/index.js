var tables;
var search_name;

$(document).ready(function() {

    //# initialize the datatable
    tables = $('#'+tableData).DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'scrollX': true,
        'paging' : true,
        'autoWidth': false,
        'destroy': true,
        'responsive': false,
        'ajax': {
            'url': linkstore,
            'type': 'POST',
            'data': function(data) {
                data.search_name = $('#search_name').val();
            },
        },
        'order': [1, 'ASC'],
    });

    $("#"+tableData+"_filter").css("display", "none");
    // $("#tables_length").css("display", "none");

    tables.columns.adjust().draw();

    $('#search_name').on('keyup', function(event) { // for text boxes
        tables.ajax.reload(); //just reload table
    });
});

function remove(id)
{
    $("#btn-delete").removeAttr('class');
    $("#btn-delete").text('Remove');
    $("#btn-delete").addClass('btn btn-danger');
    $("#removeModal h5").text('Remove');
    $("#messages_modal_remove").html('');
    $("#id span").html('Remove '+' <strong> '+id+'</strong>');
    if(id){
        $("#removeForm").on('submit', function() {
            var form = $(this);
            // remove the text-danger
            $(".text-danger").remove();

            if(id !== null){
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: { id:id },
                    dataType: 'json',
                    success:function(response) {

                        tables.ajax.reload(null, false);

                        if(response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible fade show" role="alert">'+
                                '<strong>'+response.messages+ '</strong>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');

                            // hide the modal
                            $("#removeModal").modal('hide');

                        } else {

                            $("#messages_modal_remove").html('<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
                                '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span>  '+response.messages+ '</strong>' +
                                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>' +
                            '</div>');
                        }
                    }
                });
            }
            id = null;
            return false;
        });
    }
}