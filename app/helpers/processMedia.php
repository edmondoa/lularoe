<?php
	// process and store media
    if (Input::file('media') || Input::file('image')) {
		
        // upload and link to image
        $filename = '';
        if (Input::hasFile('media') || Input::file('image')) {
			
        	if (Input::hasFile('media')) {
        		$files = Input::file('media');
				$file_type = 'media';
			}
			else {
				$files = Input::file('image');
				$file_type = 'image';
			}
			$index = 0;
			$processed_files = [];
			
			foreach($files as $file) {
				
				if (!file_exists(public_path() . '/uploads/' . date('Y') . '/' . date('m'))) {
				    mkdir(public_path() . '/uploads/' . date('Y') . '/' . date('m'), 0755, true);
				}

				$path = date('Y') . '/' . date('m') . '/';
                $fullPath = public_path() . '/uploads/' . date('Y') . '/' . date('m') . '/';
                $extension = strtolower($file->getClientOriginalExtension());

				$filename = basename($_FILES[$file_type]["name"][$index]);
				$filename = explode('.', $filename);
				$filename = $filename[0];
				
				$url = $path . $filename . '.' . $extension;
				$existing_file = Media::where('url', $url)->get();
				if (count($existing_file) > 0) {
					$filename = str_random(20);
					$url = $path . $filename . '.' . $extension;
				}

                $uploadSuccess = $file->move($fullPath, $filename . '.' . $extension);
				
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
					// make thumbs directory if doesn't exist
					if (!file_exists(public_path() . '/uploads/' . date('Y') . '/' . date('m') . '/thumbs')) {
					    mkdir(public_path() . '/uploads/' . date('Y') . '/' . date('m') . '/thumbs', 0755, true);
					}
	                // open an image media
					$img = Image::make(public_path() . '/uploads/' . $path . $filename . '.' . $extension)
	                // now you are able to resize the instance
	                ->save(public_path() . '/uploads/' . $path . $filename . '.' . $extension)
					->fit(200, 200)
	                ->save(public_path() . '/uploads/' . $path . $filename . '-sm' . '.' . $extension)
					->destroy();
					// unlink(public_path() . '/uploads/' . $path . $filename);
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
				if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) $user_id = 0;
				else $user_id = Auth::user()->id;
								
				// for single file
				if (count($files) < 1) {
	                $data['url'] = $url;
					$data['user_id'] = $user_id;
					if (isset($data['title'])) {
						if ($data['title'] == '') $data['title'] = $filename . '.' . $extension;
					}
				}
				
				// for multiple files
				else {
					$file_number = $index + 1;
					if ($index < 10) $file_number = '00' . $file_number;
					elseif ($index < 100) $file_number = '0' . $file_number;
	                $processed_files[$index]['url'] = $url;
					$processed_files[$index]['user_id'] = $user_id;
					$processed_files[$index]['type'] = $data['type'];
					if (isset($data['title'])) {
						if ($data['title'] == '') {
							$processed_files[$index]['title'] = $filename . '.' . $extension;
						}
						else $processed_files[$index]['title'] = $data['title'] . ' ' . $file_number;
					}
					if (isset($data['description'])) $processed_files[$index]['description'] = $data['description'];
					$processed_files[$index]['reps'] = $data['reps'];
					$index ++;
				}
			}

        }
    }
