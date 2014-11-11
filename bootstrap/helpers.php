<?php

##############################################################################################
function format_currency($unformatted_number,$number_digits = 6) {
	if(!is_numeric($unformatted_number))
	{
		$unformatted_number = 0;
	}
	$commas = CEIL(($number_digits-3)/3);
	$number_digits = $number_digits+$commas+3;
	return "$".str_replace(" ", "&nbsp;", str_pad(number_format($unformatted_number,2),$number_digits," ",STR_PAD_LEFT));
}

// format phone numbers (remove parenthases, spaces, and hyphens)
function formatPhone($phone) {
	return preg_replace('/\D+/', '', $phone);
}

// remove subdomain
function removeSubdomain($url) {
	return preg_replace('/\/\/.*\./', '//', $url);
}

?>