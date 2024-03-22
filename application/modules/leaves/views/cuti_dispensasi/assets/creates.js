$(document).ready(function() {

    $('#status_absensi_id').change(function() {
        var id = $(this).val();
        $.ajax({
            url: base_url + 'leaves/cuti_dispensasi/sub_cuti',
            method: "POST",
            data: { id: id },
            async: true,
            dataType: 'json',
            success: function(data) {

                var html = '';
                var html2 = '';
                var note = '';
                var i;
                var tgl_mulai = $('#datepicks').val();

                for (i = 0; i < data.length; i++) {
                    var jum_hari = data[i].jumlah_hari;

                    var tgl_akhir =  addDays(tgl_mulai, jum_hari -1 );

                    html += '<option value=' + data[i].jumlah_hari + '>' + data[i].jenis_cuti + '</option>';
                    note += '<small> * Cuti dispensasi "' +data[i].ket_absen+ ' (' + data[i].jumlah_hari + ' hari) " dimulai ' + tgl_mulai + ' sampai ' + tgl_akhir + '</small>';

                    html2 += '<input value=' + data[i].j2 + ' name="biaya" class="form-control" type="text" readonly>';
                    html2 += '<input hidden value=' + data[i].jenis + ' name="jenis_tunjangan" class="form-control" type="text">';
                    html2 += '<input hidden value=' + data[i].jenis_cuti + ' name="kode_status_absensi" class="form-control" type="text">';
                    html2 += '<input hidden value=' + data[i].absensi_id + ' name="absensi_id" class="form-control" type="text">';
                    html2 += '<input hidden value=' + data[i].jabatan_id + ' name="jabatan_id" class="form-control" type="text">';
                }
                $('#note').html(note);
                $('#sub_category').html(html);
                $('#biaya').html(html2);

            }
        });
        return false;
    });

    function addDays(str, days) {
        var date = new Date(str);
        var timestamp = date.getTime();
        var newDate = new Date(timestamp + days*24*60*60*1000);
        var result = $.datepicker.formatDate('yy-mm-dd', newDate);
        return result;
    }



    $(function() {
        $.getJSON(base_url + 'leaves/cuti/hari_libur', function(json) {
            dates = json;
        });
        $("#datepicks").datepicker({
            autoclose: true,
            dateFormat: 'yy-mm-dd',
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
            changeMonth: true,
            changeYear: true,
            changeTime: true,
            setDate: new Date(),
            beforeShowDay: checkAvailability,
        });
        $("#datepicks2").datepicker({
            dateFormat: 'yy-mm-dd',
            setDate: new Date(),
        });
        $("#datepicks3").datepicker({
            dateFormat: 'yy-mm-dd',
            setDate: new Date(),
        });
    })

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

});
