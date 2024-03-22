
$(document).ready(function() {


    // Date Picker benar
    $('#dtfirst').datetimepicker({
        format: 'YYYY-MM-DD',
    });
    var count = 1;

    function add_input_field(count) {

        var html = '';

        if (count > 1) {

            html += ' <div class="form-group mb-3" id="dtTgl"><div class="input-group typeahead-container" id="dtTgl">'+
                        '<div class="input-group">'+
                            '<span class="input-group-text input-group-append input-group-addon typeahead"><i class="simple-icon-calendar"></i></span>'+
                            '<input type="text" class="form-control" id="dtselect'+count+'" name="tgl_tdk_masuk[]" placeholder="Pilih Tanggal"  />'
            ;
        }
        var remove_button = '';

        if (count > 1) {
            remove_button = '<div class="input-group-append">'+
                                '<button type="button" name="remove" class="btn btn-danger default remove">'+
                                    '<i class="fa fa-trash"></i>'+
                                '</button>'+
                            '</div>';
        }

        html += remove_button +
                        '</div>'+
                    '</div></div>';

        return html;

    }

    $('#item_table').prepend(add_input_field(1));

    $('.selectpicker').selectpicker('refresh');

    $(document).on('click', '.add', function() {

        count++;
        $('#item_table').prepend(add_input_field(count));

        $('.selectpicker').selectpicker('refresh');

        $('#dtselect'+count).datetimepicker({
            format: 'YYYY-MM-DD',
        });

    });

    $(document).on('click', '.remove', function() {

        const element = document.getElementById("dtTgl");
        element.remove();

        // $(this).closest('tr').remove();

    });

    // Get Data Karyawan
    $('#getKaryawan').change(function(){
        var nip = $(this).val();
        $.ajax({
            method: "POST",
            url: base_url + 'leaves/hrd_cuti/getKaryawan/',
            dataType:"json",
            data: { 'nip': nip },
            success: function(data) {

                if(data.normatif === null){
                    var html_normatif = '';
                    html_normatif += 'Tidak Ada Saldo' +
                            '<input type="text" hidden value="" name="mulai_berlaku_normatif" class="form-control" >'+
                            '<input type="text" hidden value="" name="akhir_berlaku_normatif" class="form-control" >';
                    $('#sisa_normatif').html(html_normatif);

                }else{

                    var html_normatif = '';
                    html_normatif += '<input type="text" disabled value="' + data.normatif.sisa_normatif + '" name="sisa_normatif" class="form-control" >' +
                            '<input type="text" hidden value="' + data.biodata_id + '" name="biodata_id">'+
                            '<input type="text" hidden value="' + data.normatif.tgl_mulai_berlaku + '" name="mulai_berlaku_normatif">'+
                            '<input type="text" hidden value="' + data.normatif.tgl_akhir_berlaku + '" name="akhir_berlaku_normatif">';
                    $('#sisa_normatif').html(html_normatif);


                }


            }
        })
    });

});