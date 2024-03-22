$(document).ready(function() {
    $(function() {
        $('#datetimepicks').datetimepicker();
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
        $.getJSON(base_url + 'leaves/terlambat/hari_libur', function(json) {
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


});