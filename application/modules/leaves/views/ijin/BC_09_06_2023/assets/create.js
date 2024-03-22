$(document).ready(function() {
    $(function() {
        $('#datetimepicks').datetimepicker({
            dateFormat: 'H:i'
        });
        $('#datetimepicks2').datetimepicker();
        
    });
    $(function() {
        $("#chkPassport").click(function() {
            if ($(this).is(":checked")) {
                $("#dvPassport").show();
                $("#AddPassport").hide();
            } else {
                $("#dvPassport").hide();
                $("#AddPassport").show();
            }
        });
    });

    $(function() {
        $.getJSON(base_url + 'leaves/ijin/hari_libur', function(json) {
            dates = json;
        });
        $("#datetimepick").datetimepicker({
            minDate: 1,
            dateFormat: 'yy-mm-dd',
            beforeShowDay: checkAvailability,
        });
    });

    $("#datetimepick2").datetimepicker({
        setDate: new Date(),
        minDate: 0,
        dateFormat: 'h:i:s',
    });

    $("#datetimepick3").datetimepicker({
        setDate: new Date(),
        minDate: 0,
        dateFormat: 'h:i:s',
    });

    function checkAvailability(mydate) {
        var myBadDates = dates;
        var $return = true;
        var $returnclass = "available";
        $checkdate = $.datepicker.formatDate('yy-mm-dd', mydate);

        // start loop
        for (var x in myBadDates) {
            if (myBadDates[x].dates == $checkdate) {
                $return = false;
                $returnclass = "unavailable";
            }
        } //end loop
        return [$return, $returnclass];
    }


    $('#addnew').click(function() {

        $.getJSON(base_url + 'leaves/cuti/hari_libur', function(json) {
            dates = json;
        });
        $('#datetimepicks').datetimepicker();
        // increment the counter
        newRowNum = $(TableCuti).children('tbody').children('tr').length + 1;
        var addRow = $(this).parent().parent();
        var newRow = addRow.clone();
        $('input', addRow).val('');
        // insert a remove link in the last cell
        $('td:last-child', newRow).html('<a href="" class="btn btn-danger remove"><i class="fa fa-trash"><\/i> Hapus<\/a>');
        // insert the new row into the table
        // "before" the Add row
        addRow.before(newRow);
        // $(".datepick").datepicker();
        $('#datetimepicks').datetimepicker();

        // add the remove function to the new row
        $('a.remove', newRow).click(function() {
            $(this).closest('tr').remove();
            return false;
        });
        $('#date', newRow).each(function(i) {
            var newID = 'datepicks' + newRowNum;
            $(this).attr('id', newID);
        });
        // prevent the default click
        return false;
    });

    $(function() {
        $('#addnew').hide();
        $('#jamhadirid').hide();
        $('#tampil_jam').hide();
        $('#status_absensi_id').change(function() {
            if ($('#status_absensi_id').val() == '000000000061') {
                $('#addnew').hide();
                $('#jamhadir').show();
                $('#jamhadirid').show();
                $('#tampil_jam').show();
            } else {
                $('#addnew').show();
                $('#jamhadir').show();
                $('#jamhadirid').hide();
                $('#tampil_jam').hide();
            }
        });
    });

    $('#datepickbc').datetimepicker({
        // changeMonth: true,
        // changeYear: true,
        // dateFormat: "yy-mm-dd",
        // autoclose: true,

        onSelect: function() {
            var tgl = $(this).val();
            $.ajax({
                url: base_url + 'leaves/ijin/getAbsenMasuk/',
                method: "POST",
                data: { tgl: tgl },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    html += '<input disabled value=' + data.jm + ' name="jam_masuk" class="form-control" >';
                    $('#jam_masuk').html(html);
                }
            });
            return false;
        },

    });

    $(function() {
        $('#datetimepicker2a3').datetimepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            autoclose: true,

            onSelect: function() {
                var tgl = $(this).val();
                $.ajax({
                    url: base_url + 'leaves/ijin/getAbsenMasuk/',
                    method: "POST",
                    data: { tgl: tgl },
                    async: true,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        html += '<input disabled value=' + data.jm + ' name="jam_masuk" class="form-control" >';
                        $('#jam_masuk').html(html);
                    }
                });
                return false;
            },

        });
    });

    // Date Picker benar
    $('#datetimepicker23').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
    });

    $("#datetimepicker23").on("dp.change", function() {

        var tgl = $(this).val();
        $.ajax({
            url: base_url + 'leaves/ijin/getAbsenMasuk/',
            method: "POST",
            data: { tgl: tgl },
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                html += '<input disabled value=' + data.jm + ' name="jam_masuk" class="form-control" >';
                $('#jam_masuk').html(html);
            }
        });

    });
    // Date Picker benar

    // $("#datepick").datepicker({
    //     timepicker: false,
    //     format: 'd/m/Y',
    //     closeOnDateSelect: true
    // }).on('dp.change', function(ev) {
    //     exampleFunction(); //your function call
    // });


    var count = 1;

    function add_input_field(count) {

        var html = '';
        if (count > 1) {
            html += '<tr>';

            html += '<td><input type="date" name="tgl_tdk_masuk[]" class="form-control item_name" /></td>';

            html += '<td><div id="dvPassport" style="display: none"> <div class="input-group "><input type="date" class="form-control" name="tgl_kembali[]" placeholder="Pilih Tanggal"></div> </div><div id="AddPassport">Kembali</div></td>';

            html += '<td><input type="text" name="keterangan_cuti[]" class="form-control keterangan_cuti" /></td>';
        }
        var remove_button = '';

        if (count > 1) {
            remove_button = '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i> Batal</button>';
        }

        html += '<td>' + remove_button + '</td></tr>';

        return html;

    }

    $('#item_table').append(add_input_field(1));

    $('.selectpicker').selectpicker('refresh');

    $(document).on('click', '.add', function() {

        count++;
        $('#item_table').prepend(add_input_field(count));

        $('.selectpicker').selectpicker('refresh');

    });

    $(document).on('click', '.remove', function() {

        $(this).closest('tr').remove();

    });


});