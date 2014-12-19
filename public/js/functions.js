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
       $('form').attr('action', $(this).val()); 
    });
    
    // jQUery UI
    
    var today = new Date();
    var firstYear = today.getFullYear() - 18;
    $('.datepicker').datetimepicker({
        controlType: 'select',
        timeFormat: 'hh:mm tt'
    });
    $('.dateonlypicker').datepicker({
        controlType: 'select',
        changeMonth: true,
        changeYear: true,
        yearRange: '1900:' + firstYear,
        dateFormat: 'yy-mm-dd',
        //timeFormat: 'hh:mm tt'
    });
    
    // highlight active page in main-menu
    path = path.split('/');
    $('#main-menu a').each(function() {
        if ($(this)[0].hasAttribute('href') && $(this).attr('href') !== 'javascript:void(0)') href = $(this).attr('href').split('/');
        else if ($(this)[0].hasAttribute('data-href')) href = $(this).attr('data-href').split('/');
        if (href[1] == path[0]) {
            $(this).addClass('active');
        }
    });
    
    // initialize bootstrap popovers
    $("[data-toggle='popover']").popover({html:true, trigger:'click'});
    
    // delete label
    $('.form-group .label .fa-times').click(function() {
       $(this).parent().remove(); 
    });
    
    // initialize fraola WYSIWYG editor
    // $(function() {
        // $('.wysiwyg').editable({
            // beautifyCode: true,
            // height: 400,
            // inlineMode: false,
            // plainPaste: true,
            // imageUploadURL: '/upload-image',
        // });
    // });
    
    // initialize tinymce
    tinymce.init({
        selector: ".wysiwyg",
        theme: "modern",
        relative_urls: false,
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ]
    });
    
    // add buttons to tinymce editor for inserting images
    // $('body').on({
        // click: function() {
            // $('input#mceu_44-inp').before('' +
                // '<div id="uploadImage" style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important; border-top-left-radius:4px !important; border-bottom-left-radius:4px !important;" title="Upload Image" role="button" class="mce-btn">' +
                    // '<button data-toggle="modal" data-target="#imageUpload" style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important; border-top-left-radius:4px !important; border-bottom-left-radius:4px !important;" role="presentation" type="button" tabindex="-1">' +
                        // '<img style="height:16px; width:16px;" src="/img/upload.svg">' +
                    // '</button>' +
                // '</div>' +
                // '<div style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important;" title="Media Library" role="button" class="mce-btn">' +
                    // '<button style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important;" role="presentation" type="button" tabindex="-1">' +
                        // '<img style="height:16px; width:16px;" src="/img/tiles.svg">' +
                    // '</button>' +
                // '</div>' +
            // '');
            // $('input#mceu_44-inp').addClass("mceu_44-inp-hack");
            // $('#modals').load('/helpers/modals.php');
        // }
    // }, '#mceu_16');
    
    // close sidebar menu popovers when clicking outside
    $('[data-toggle="popover"]').popover();
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
 
});

// clean URL
function cleanURL(text) {
    text = text.toLowerCase();
    text = text.toLowerCase();
    text = text.replace(/ a /g, "-");
    text = text.replace(/ an /g, "-");
    text = text.replace(/ it /g, "-");
    text = text.replace(/ the /g, "-");
    text = text.replace(/\ and /g, "-");
    text = text.replace(/\ /g, "-");
    text = text.replace(/\,/g, "-");
    text = text.replace(/\./g, "-");
    text = text.replace(/\&/g, "-");
    text = text.replace(/\?/g, "-");
    text = text.replace(/\!/g, "-");
    text = text.replace(/\@/g, "-");
    text = text.replace(/\#/g, "-");
    text = text.replace(/\$/g, "-");
    text = text.replace(/\%/g, "-");
    text = text.replace(/\^/g, "-");
    text = text.replace(/\*/g, "-");
    text = text.replace(/\(/g, "-");
    text = text.replace(/\)/g, "-");
    text = text.replace(/\+/g, "-");
    text = text.replace(/\=/g, "-");
    text = text.replace(/\~/g, "-");
    text = text.replace(/\`/g, "-");
    text = text.replace(/\:/g, "-");
    text = text.replace(/\;/g, "-");
    text = text.replace(/\'/g, "-");
    text = text.replace(/\"/g, "-");
    text = text.replace(/\[/g, "-");
    text = text.replace(/\{/g, "-");
    text = text.replace(/\]/g, "-");
    text = text.replace(/\}/g, "-");
    text = text.replace(/\\/g, "-");
    text = text.replace(/\|/g, "-");
    text = text.replace(/\</g, "-");
    text = text.replace(/\>/g, "-");
    text = text.replace(/\--/g, "");
    text = text.replace(/\__/g, "");
    text = text.replace(/\_-/g, "");
    text = text.replace(/\-_/g, "");
    return cleaned_text = text;
}