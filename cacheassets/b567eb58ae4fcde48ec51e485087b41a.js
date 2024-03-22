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
                html += '<input disabled value="' + data.jm + '" name="jam_masuk" class="form-control" >';
                $('#jam_masuk').html(html);
            }
        });

    });
    // Date Picker benar




    var count = 1;

    function add_input_field(count) {

        var html = '';

        if (count > 1) {
            html += '<tr>';

            html += '<td><div class="input-group">'+
            '<span class="input-group-text input-group-append input-group-addon"><i class="simple-icon-calendar"></i></span>' +
            '<input type="text" class="form-control" id="datetimepickerss'+count+'" name="tgl_tdk_masuk[]" placeholder="Pilih Tanggal"  /></div></td>';

            html += '<td><div id="dvPassport" style="display: none"> <div class="input-group "><input type="datetimepicker23" class="form-control" value="-" name="tgl_kembali[]" placeholder="Pilih Tanggal"></div> </div><div id="AddPassport">Kembali</div></td>';

            html += '<td><input type="text" name="keterangan_cuti[]" class="form-control keterangan_cuti" placeholder="Keterangan" /></td>';
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

        $('#datetimepickerss'+count).datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
        });

    });

    $(document).on('click', '.remove', function() {

        $(this).closest('tr').remove();

    });

    var count = 2;
	$('.addlampiran').click(function () {
	if(count<4) {
		$('.blocklampiran:last').before('<div class="blocklampiran">'+
		'<div class="card-body">' +
			'<h5><span> Lampiran '+ count +'</span></h5>' +
			'<div class="center">' +
				'<div class="form-input">'+
					'<div class="preview'+count+'">' +
						'<img data-fancybox="gallery"  id="file-ip-'+count+'-preview">'+
					'</div>'+
					'<label class="btn btn-primary btn-xs btn-pill " for="file-ip-'+count+'">Select Image</label>'+
					'<span  class="removelampiran btn btn-danger btn-xs btn-pill mb-2"> Remove </span>'+
					'<input type="file" class="form-control-file" name="file_'+count+'" id="file-ip-'+count+'" accept="image/*" onchange="showPreview'+count+'(event);">'+
				'</div>'+
			'</div>'+
		'</div>');
		// alert(count);
		count++;
		if (count==4) {
			$('.addlampiran').hide();
		}
	}
	});


	$('.optionlampiran').on('click', '.removelampiran', function() {
		$(this).closest('.blocklampiran').remove();
		$('.addlampiran').show();
		count--;
	});

});