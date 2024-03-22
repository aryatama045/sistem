$(document).ready(function() {

    $('#tgl_awalss').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        autoclose: true,
        beforeShow: function(input, inst) { setDatepickerPos(input, inst) },

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

    function setDatepickerPos(input, inst) {
        var rect = input.getBoundingClientRect();
        // use 'setTimeout' to prevent effect overridden by other scripts
        setTimeout(function() {
            var scrollTop = $("body").scrollTop();
            inst.dpDiv.css({ top: rect.top + input.offsetHeight + scrollTop });
        }, 0);
    }


    // Date Picker benar
    $('#tgl_awal').datetimepicker({
        format: 'YYYY-MM-DD',
    });

    $("#tgl_awal").on("dp.change", function() {

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
        $.ajax({
            url: base_url + 'leaves/cuti_tambahan/getOvertime/',
            method: "POST",
            data: { tgl: tgl },
            async: true,
            dataType: 'json',
            success: function(data) {
                var html3 = '';
                html3 += '<input disabled value="' + data.no_dokumen + '" name="no_dokumen" class="form-control" >';
                $('#no_dokumen').html(html3);
            }
        });

    });
    // Date Picker benar


});