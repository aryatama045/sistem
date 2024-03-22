var newRowNum = 0;

$(document).ready(function() {

    $("#datepick").datepicker({
        // minDate: 0,
        dateFormat: 'yy-mm-dd',
        beforeShowDay: checkAvailability,
    });
    var count = 0;

    function add_input_field(count) {

        var html = '';

        html += '<tr>';

        html += '<td><input type="date" name="tgl_tdk_masuk[]" class="form-control item_name" /></td>';

        var remove_button = '';

        if (count > 0) {
            remove_button = '<button type="button" name="remove" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button>';
        }

        html += '<td>' + remove_button + '</td></tr>';

        return html;

    }

    $('#item_table').append(add_input_field(0));

    $('.selectpicker').selectpicker('refresh');

    $(document).on('click', '.add', function() {

        count++;
        $("#datepick").datepicker({
            // minDate: 0,
            dateFormat: 'yy-mm-dd',
            // beforeShowDay: checkAvailability,
        });
        $('#item_table').prepend(add_input_field(count));

        $('.selectpicker').selectpicker('refresh');

    });

    $(document).on('click', '.remove', function() {

        $(this).closest('tr').remove();

    });

    $(function() {
        $.getJSON(base_url + 'leaves/cuti/hari_libur', function(json) {
            dates = json;
        });
        $("#datepick").datepicker({
            // minDate: 0,
            dateFormat: 'yy-mm-dd',
            beforeShowDay: checkAvailability,
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

    $('#addnew').click(function() {

        $.getJSON(base_url + 'leaves/cuti/hari_libur', function(json) {
            dates = json;
        });
        $("#datepick").datepicker({
            // minDate: 0,
            dateFormat: 'yy-mm-dd',
            beforeShowDay: checkAvailability,
        });
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
        $("#datepick").datepicker({
            // minDate: 0,
            dateFormat: 'yy-mm-dd',
            beforeShowDay: checkAvailability,
        });

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