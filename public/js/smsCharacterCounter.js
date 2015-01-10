$(document).ready(function(){	
	$('#text_message').keyup(function() {
		var maxChar = 135;
		var charLength = $(this).val().length;
		var left;
		if(charLength > maxChar) {
			var shortText = $(this).val().substring(0, maxChar);
			$(this).val(shortText);
			$('span#charCount').html('<strong>You may only have up to ' + maxChar + ' characters.</strong>');
		} else {
			left = maxChar - charLength;
			$('span#charCount').html(left + ' characters left');
		}
		
	});	
});

