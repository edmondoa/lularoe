			// bulk action checkboxes
			$scope.checkbox = function() {
				var checked = false;
				$('.bulk-check').each(function() {
				if ($(this).is(":checked")) checked = true;
				});
				if (checked == true) $('.applyAction').removeAttr('disabled');
				else $('.applyAction').attr('disabled', 'disabled');
			};
			
			$('.loading').remove();