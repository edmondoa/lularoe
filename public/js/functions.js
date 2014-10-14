$(document).ready(function() { 
    
    // initialize bootstrap-select plugin
    $('.selectpicker').selectpicker();
   
    // check the checkboxes of all rows in a table and enable/disable action button
    $("thead input[type='checkbox']").click(function() {
        if ($(this).prop("checked") == false) {
            $("tbody td:first-child input[type='checkbox']").each(function() {
                $(this).prop("checked", false);
            });
            $('.applyAction').attr('disabled', 'disabled');
        }
        else {
            $("tbody td:first-child input[type='checkbox']").each(function() {
                $(this).prop("checked", true);
            });
            $('.applyAction').removeAttr('disabled');
        }
    });
    $(".bulk-check").click(function() {
        var checked = false;
        $(".bulk-check").each(function() {
            if ($(this).prop("checked") == true) checked = true;
        });
        if (checked == false) {
            $('.applyAction').attr('disabled', 'disabled');
        }
        else {
            $('.applyAction').removeAttr('disabled');
        }
    });
    
    // change method of index form
    $('select.actions').change(function() {
       $('form').attr('action', $(this).val() + '/0'); 
    });
    
    // jQUery UI
    
    var today = new Date();
    var firstYear = today.getFullYear() - 18;
    $('.dateonlypicker').datepicker({
        controlType: 'select',
        changeMonth: true,
        changeYear: true,
        yearRange: '1900:' + firstYear,
        dateFormat: 'yy-mm-dd',
        //timeFormat: 'hh:mm tt'
    });
    
});