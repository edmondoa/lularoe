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

function processMedia($data, $media, $filename) {

    // upload and link to image
    $filename = '';

	if (!file_exists('/uploads/' . date('Y') . '/' . date('m'))) {
	    mkdir('/uploads/' . date('Y') . '/' . date('m'), 0755, true);
	}

	$path = date('Y') . '/' . date('m') . '/';
    $fullPath = public_path() . '/uploads/' . date('Y') . '/' . date('m') . '/';
    $extension = $media->getClientOriginalExtension();

	// generate media name and check for existing
	$url = $path . $filename;
	$existing_file = Media::where('url', $url)->get();
	while (count($existing_file) > 0) {
		$filename = str_random(20) . '.' . $extension;
	}

    $uploadSuccess = $media->move($fullPath, $filename);
	
	// common media types		
	$raster_image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
	$image_extensions = ['svg', 'tiff', 'psd', 'ai', 'eps'];
	$video_extensions = ['avchd', 'avi', 'flv', 'mpeg', 'mpg', 'mp4', 'wmv', 'mov', 'flv', 'rm', 'vob', 'swf'];
	$audio_extensions = ['wav', 'mp3', 'wma', 'flac', 'ogg', 'ra', 'ram', 'rm', 'mid', 'aiff', 'mpa', 'm4a', 'aif', 'iff'];
	$pdf_extensions = ['pdf'];
	$document_extensions = ['doc', 'docx', 'odt', 'pages', 'rtf', 'wpd', 'wps'];
	$spreadsheet_extensions = ['gnumeric', 'gnm', 'ods', 'xls', 'xlsx', 'xlsm', 'xlsb', 'csv'];
	$text_extensions = ['txt', 'log', 'msg', 'tex'];
	$presentation_extensions = ['key', 'ppt', 'pptx', 'odp'];
	$code_extensions = ['html', 'php', 'js', 'xml', 'json', 'c', 'class', 'cpp', 'cs', 'dtd', 'fla', 'h', 'java', 'lua', 'm', 'pl', 'py', 'sh', 'sln', 'swift', 'vcxproj', 'xcodeproj'];
	$database_extensions = ['odb', 'db', 'mdb', 'accdb', 'dbf', 'pdb', 'sql'];
	$archive_extensions = ['7z', 'cbr', 'deb', 'gz', 'pkg', 'rar', 'rpm', 'sitx', 'tar.gz', 'zip', 'zipx'];
			
	// determine media type
	if (in_array($extension, $raster_image_extensions)) {
        // open an image media
		$img = Image::make('uploads/' . $path . $filename);

        // now you are able to resize the instance
        $img->fit(800, 600);

        // finally we save the image as a new image
        $img->save('uploads/' . $path . $filename);
		$data['type'] = 'Image';
	}
	elseif (in_array($extension, $image_extensions)) $data['type'] = 'Image media';
	elseif (in_array($extension, $video_extensions)) $data['type'] = 'Video';
	elseif (in_array($extension, $audio_extensions)) $data['type'] = 'Audio';
	elseif (in_array($extension, $pdf_extensions)) $data['type'] = 'PDF';
	elseif (in_array($extension, $document_extensions)) $data['type'] = 'Document';
	elseif (in_array($extension, $spreadsheet_extensions)) $data['type'] = 'Spreadsheet';
	elseif (in_array($extension, $text_extensions)) $data['type'] = 'Text';
	elseif (in_array($extension, $presentation_extensions)) $data['type'] = 'Presentation';
	elseif (in_array($extension, $code_extensions)) $data['type'] = 'Code';
	elseif (in_array($extension, $database_extensions)) $data['type'] = 'Database';
	elseif (in_array($extension, $archive_extensions)) $data['type'] = 'Archive';
	else $data['type'] = 'File';

	// assign values to data array
    $data['url'] = $url;
	$data['user_id'] = Auth::user()->id;
	if ($data['title'] == '') $data['title'] = $filename;
	
	return $data;
	
}

?>