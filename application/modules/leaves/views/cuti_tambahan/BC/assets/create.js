$(document).ready(function() {

    $('#tgl_awal').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",

        onSelect: function() {
            var tgl = $(this).val();
            $.ajax({
                url: base_url + 'leaves/cuti_tambahan/getAbsenMasuk/',
                method: "POST",
                data: { tgl: tgl },
                async: true,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    html += '<input disabled value=' + data.jm + ' name="jam_masuk" class="form-control" >';
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
                    html2 += '<input disabled value=' + data.jk + ' name="jam_keluar" class="form-control" >';
                    $('#jam2').html(html2);
                }
            });
            return false;
        },

    });


});