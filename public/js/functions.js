$(document).ready(function() {
    
    // // resize image-full class
    // function resizeFullImage() {
		// width = $('.full-image').width();
		// height = $('.full-image').height();
    // $('.full-image').
//     	
    // };
    
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
    $.extend($.datepicker,{_checkOffset:function(inst,offset,isFixed){return offset}});
    
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
    $("[data-toggle='popover']").popover({
    	html:true,
    	trigger:'click'
    });
    
    // delete label
    $('.form-group .label .removeContact').click(function() {
       $(this).parent().parent().remove();
    });
    
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
	function addMediaButtons() {
        $('.mce-combobox.mce-last.mce-abs-layout-item .mce-textbox').before('' +
            '<div id="uploadImage" style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important; border-top-left-radius:4px !important; border-bottom-left-radius:4px !important;" title="Upload Image" role="button" class="mce-btn">' +
                '<button data-toggle="modal" data-target="#imageUpload" style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important; border-top-left-radius:4px !important; border-bottom-left-radius:4px !important;" role="presentation" type="button" tabindex="-1">' +
                    '<img style="height:16px; width:16px;" src="/img/upload.svg">' +
                '</button>' +
            '</div>' +
            '<div data-toggle="modal" data-target="#mediaLibrary" style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important;" title="Media Library" role="button" class="mce-btn">' +
                '<button style="border-top-right-radius:0 !important; border-bottom-right-radius:0 !important;" role="presentation" type="button" tabindex="-1">' +
                    '<img style="height:16px; width:16px;" src="/img/tiles.svg">' +
                '</button>' +
            '</div>' +
        '');
        $('input#mceu_44-inp').addClass("mceu_44-inp-hack");
        addedMediaButtons = true;
	}
    $('body').on('click', '#mceu_16', function() {
		addMediaButtons();
    });
    
    // load media modals if WYISYG editor exists
    // if ($('.wysiwyg').length > 0) {
    	// if ($('#modals').html() == '') $('#modals').load('/helpers/media-modals');
    // }
    
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
    
    // add tag
	$(window).keydown(function(event) {
		element = $('.tagger.new');
		if ($(element).is(':focus')) {
			if(event.keyCode == 13 /* enter */ || event.keyCode == 9 /* tab */ || event.keyCode == 188 /* comma */) {
				event.preventDefault();
				addTag(element);
			}
		}
	}); 
	$('.addTag').click( function() {
		addTag($(this));
	});
	function addTag(element) {
		tagger = $(element).parents('.input-group').children('.tagger');
		if ($(tagger).val() != '') {
			var tag = $(tagger).val();
			$('.tag-list').append('' +
				'<span class="label label-default">' +
					tag + '&nbsp;' +
					'<i class="fa fa-times simpleRemoveTag"></i>' +
					'<input type="hidden" name="tag_names[]" value="' + tag + '">' +
				'</span>' +
			'');
			$(tagger).val('');
		}
	};
	
	// simple remove tag
	$('body').on('click', '.simpleRemoveTag', function() {
		$(this).parent().remove();
	});
    
    // remove tag
    $('.removeTag').click(function() {
        var id = $(this).attr('data-tag-id');
        $(this).parent().remove();
        $.get('/api/remove-tag/' + id);
    });
    
    // add item
	$(window).keydown(function(event) {
		if ($('#add-items').is(':focus')) {
			if(event.keyCode == 13 /* enter */) {
				event.preventDefault();
				addItem();
			}
		}
	}); 
	$('#add-item-button').click( function() {
		if ($("#add-item").val() != null) {
			addItem();
		}
	});
	function addItem() {
		if ($('#add-item').val() != '') {
			product_items_count ++;
			var item_id = $('#add-item').val();
			var item_name = $('#add-item option:selected').html();
			$('.item-list').prepend('' +
        		'<li class="list-group-item display-table width-full">' +
        			'<input type="hidden" name="items[' + product_items_count + '][new_product_item]" value="1">' +
        			'<input type="hidden" name="items[' + product_items_count + '][item_id]" value="' + item_id + '">' +
        			'<div class="table-cell quantity">' +
        				'<input type="text" name="items[' + product_items_count + '][quantity]" class="form-control" value="1">' +
        			'</div>' +
        			'<div class="table-cell">' + item_name + '</div>' +
	        		'<div class="table-cell align-left">' +
	        			'<i class="fa fa-times removeItem pull-right" data-item-id="' + product_id + '" data-product-id="' + product_id + '"></i>' +
					'</div>' +
        		'</li>' +
			'');
			$('#add-item').val('');
		}
	};

    // remove item
    $('body').on('click', '.removeItem', function() {
        var item_id = $(this).attr('data-item-id');
        var product_id = $(this).attr('data-product-id');
        $(this).parents('.list-group-item').fadeOut(function() {
        	$(this).remove();
        });
        if (item_id != undefined) {
	        $.ajax({
	            type: "POST",
	            data: {
	            	'item_id' : item_id,
	            	'product_id' : product_id,
	            },
	            url: "/product-items-delete",
	            success: function(result) {
	            	console.log(result);
	            }
	        });
		}
    });

    // add image
	$('#add-image').click( function() {
		addImage();
	});
	function addImage() {
		attachment_images_count ++;
		
		// make sure a featured image is checked
		var checked = 'checked';
		$('#image-list input[type="radio"]').each(function() {
			if ($(this).is(':checked')) checked = '';
		});
		
		// append an image widget
		$('#image-list').append('' +
    		'<li class="list-group-item" data-image-id="' + attachment_images_count + '">' +
    			'<div class="display-table width-full">' +
	    			'<input type="hidden" name="images[' + attachment_images_count + '][new_attachment_image]" value="1">' +
			    	'<input type="hidden" name="images[' + attachment_images_count + '][path]" class="form-control">' +
					'<div class="btn-group swappable">' +
		                '<button title="Upload file" class="btn btn-default set_id" type="button" data-toggle="modal" data-target="#imageUpload" id="uploadImage" role="button">' +
		                    '<i class="fa fa-upload"></i> Upload' +
		                '</button>' +
		                '<button title="Select from media libray" class="btn btn-default set_id" type="button" data-toggle="modal" data-target="#mediaLibrary" role="button">' +
		                    '<i class="fa fa-th-large"></i> Library' +
		                '</button>' +
			    	'</div>' +
		            '<div class="table-cell" style="vertical-align:top;">' +
	        			'<i class="fa fa-times removeImage pull-right"></i>' +
					'</div>' +
				'</div>' +
				'<label class="margin-top-2">' +
					'<input type="radio" ' + checked + ' name="images[' + attachment_images_count + '][featured]">' +
					'&nbsp;Featured Image' +
				'</label>' +
    		'</li>' +
		'');
		$('#add-image').val('');
	};
	
	// determine which image widget to add the media to
	$('body').on('click', '#image-list button.set_id', function() {
		image_id = $(this).parents('.list-group-item').attr('data-image-id');
	});
	
	// set image as featured (uncheck other images)
	$('body').on('change', '#image-list input[type="radio"]', function() {
		$('#image-list input[type="radio"]').prop('checked', false);
		$(this).prop('checked', true);
	});

    // remove image
    $('body').on('click', '.removeImage', function() {
        var id = $(this).attr('data-attachment-id');
        $(this).parents('.list-group-item').fadeOut(function() {
        	$(this).remove();
        	// set a new featured image
        	setNewFeaturedImage();
        });
        if (id != undefined) {
			$.get("/delete-attachment/" + id, function() {
				setNewFeaturedImage();
			});
        }
        function setNewFeaturedImage() {
        	$('#image-list input[type="radio"]').prop('checked', false);
        	$('#image-list input[type="radio"]:first').prop('checked', true);
        }
    });

	// change featured image by clicking on thumbnails
	if ($("#featured-image") != undefined) {
		$('.thumb').click(function() {
			
			// swap small image with medium image
			src = $(this).attr('src');
			src = src.split('-sm');
			src = src[0] + src[1];
			
			$('#featured-image').attr('src', src);
		});
	}

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


/**
* check existence of a value inside an array
* 
* @author Randy Binondo
* @param array = haystack
* @param n = needle
* 
* @returns {Boolean}
*/
var checkExists = function(array,n){
    if(array.length){
        var res = array.filter(function(o){
            return o == n;    
        });    
        return !(!res.length);
    }
    return false;   
};

/**
* Pushing into a well maintained array containing only unique values
* 
* @author: Randy Binondo
* @param array = one dimensional array with only unique values
*                assumes array given is clean
* @param data  =  values to push
* 
*/

function pushIfNotFound(array, data){
    data.forEach(function(n){
        if(!checkExists(array,n)){
            array.push(n); 
        }  
    });
}

/**
* Holder object for all other variables
* 
* @returns {Object}
*/

var ControlPad = (function(){
    return {
        commonctrl : {}
    };
}());