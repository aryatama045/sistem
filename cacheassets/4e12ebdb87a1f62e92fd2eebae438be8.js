$(document).ready(function() {
    // Date Picker benar
    $('#datetimepicker23').datetimepicker({
        format: 'YYYY-MM-DD HH:mm',
    });

    var tgl = $("#datetimepicker23").val();
    var nip = $("#nip_user").val();
    // alert(nip);
    $.ajax({
        url: base_url + 'leaves/ijin/getAbsenMasukUser/',
        method: "POSsT",
        data: { tgl: tgl, nip: nip },
        async: true,
        dataType: 'json',
        success: function(data) {
            var html = '';
            html += '<input disabled value=' + data.jm + ' name="jam_masuk" class="form-control" >';
            $('#jam_masuk').html(html);
        }
    });

});