$(document).ready(function() {

    $('#tgl_lembur').datetimepicker({
        format: 'YYYY-MM-DD',
    });


    $(function() {
        $('#session-date').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('#session-date2').datetimepicker({
            format: 'HH:mm:ss'
        });

        // Hide datetimepicker on date change
        // $("#session-date").on("dp.change", function() {
        //     $(this).data("DateTimePicker").hide();
        // });

        // Show datetimepicker on input text click
        $('#session-date > input').on('click', function() {
            $(this).closest('.date').data('DateTimePicker').show();
        });
        $('#session-date2 > input').on('click', function() {
            $(this).closest('.date').data('DateTimePicker').show();
        });
    });


    $("#tgl_lembur").on("dp.change", function() {

        var tgl = $(this).val();
        $.ajax({
            url: base_url + 'leaves/cuti_tambahan/getAbsenMasuk/',
            method: "POST",
            data: { tgl: tgl },
            async: true,
            dataType: 'json',
            success: function(data) {
                var html = '';
                html += '<input disabled value="' + data.jm + '" name="jam_masuk" class="form-control" >';
                $('#jam1').html(html);
            }
        });
        $.ajax({
            url: base_url + 'leaves/cuti_tambahan/getAbsenKeluar/',
            method: "POST",
            data: { tgl: tgl },
            async: true,
            dataType: 'json',
            success: function(data) {
                var html2 = '';
                html2 += '<input disabled value="' + data.jk + '" name="jam_keluar" class="form-control" >';
                $('#jam2').html(html2);
            }
        });
        $('.datepicker').hide();
    });
});