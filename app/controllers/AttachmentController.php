<?php

class attachmentController extends \BaseController {

	/**
	 * Display a listing of attachments
	 *
	 * @return Response
	 */
	public function index()
	{
		$attachments = Attachment::all();

		return View::make('attachment.index', compact('attachments'));
	}

	/**
	 * Show the form for creating a new attachment
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('attachment.create');
	}

	/**
	 * Upload attachment
	 */
	 
	public function store() {

		$validator = Validator::make($data = Input::all(), Attachment::$rules);
		if ($validator->fails())
		{
			if (isset($data['ajax'])) {
				$response = [];
				$response['success'] = false;
				$response['errors'] = json_encode($validator->messages());
				return $response;
			}
			else {
				return Redirect::back()->withErrors($validator)->withInput();
			}
		}
		
				echo '<pre>'; print_r(Input::file('file')); echo '</pre>';
				// echo $data['file'];
				exit;
		
		// process and store file
        if (Input::file('file')) {

            // upload and link to image
            $filename = '';
            if (Input::hasFile('file')) {
                $file = Input::file('file');
				echo Input::file('file');
				exit;
				
				if (!file_exists('/uploads/' . date('Y') . '/' . date('m'))) {
				    mkdir('/uploads/' . date('Y') . '/' . date('m'), 0755, true);
				}

				$path = date('Y') . '/' . date('m') . '/';
                $fullPath = public_path() . '/uploads/' . date('Y') . '/' . date('m') . '/';
                $extension = $file->getClientOriginalExtension();

				// generate file name and check for existing
				$filename = str_random(20) . '.' . $extension;
				$url = $path . $filename;
				$existing_file = Attachment::where('url', $url)->get();
				while (count($existing_file) > 0) {
					$filename = str_random(20) . '.' . $extension;
				}

                $uploadSuccess = $file->move($fullPath, $filename);
				
				// common file types		
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
						
				// determine file type
				if (in_array($extension, $raster_image_extensions)) {
	                // open an image file
					$img = Image::make('uploads/' . $path . $filename);
	    
	                // now you are able to resize the instance
	                $img->fit(800, 600);
	
	                // finally we save the image as a new image
	                $img->save('uploads/' . $path . $filename);
					$data['type'] = 'Image';
				}
				elseif (in_array($extension, $image_extensions)) $data['type'] = 'Image file';
				elseif (in_array($extension, $video_extensions)) $data['type'] = 'Video';
				elseif (in_array($extension, $audio_extensions)) $data['type'] = 'Audio';
				elseif (in_array($extension, $pdf_extensions)) $data['type'] = 'PDF';
				elseif (in_array($extension, $document_extensions)) $data['type'] = 'Document';
				else if (in_array($extension, $spreadsheet_extensions)) $data['type'] = 'Spreadsheet';
				elseif (in_array($extension, $text_extensions)) $data['type'] = 'Text';
				elseif (in_array($extension, $presentation_extensions)) $data['type'] = 'Presentation';
				elseif (in_array($extension, $code_extensions)) $data['type'] = 'Code';
				elseif (in_array($extension, $database_extensions)) $data['type'] = 'Database';
				elseif (in_array($extension, $archive_extensions)) $data['type'] = 'Archive';
				else $data['type'] = 'File';

				// store record in database
                $data['url'] = $url;
				$data['user_id'] = Auth::user()->id;
				if ($data['title'] == '') $data['title'] = $file;
				echo '<pre>'; print_r($data); echo '</pre>';
				exit;
				$attachment = Attachment::create($data);
				if (isset($data['ajax'])) {
					$response['success'] = true;
					$response['url'] = '/uploads/' . $attachment->url;
					return $response;
				}
				else {
					return Redirect::route('attachments.index')->with('message', 'Media uploaded.');
				}
            }
        }
	}

	/**
	 * Display the specified attachment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$attachment = Attachment::findOrFail($id);

		return View::make('attachment.show', compact('attachment'));
	}

	/**
	 * Show the form for editing the specified attachment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$attachment = Attachment::find($id);

		return View::make('attachment.edit', compact('attachment'));
	}

	/**
	 * Update the specified attachment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$attachment = Attachment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Attachment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$attachment->update($data);

		return Redirect::route('attachments.show', $id)->with('message', 'Attachment updated.');
	}

	/**
	 * Remove the specified attachment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Attachment::destroy($id);

		return Redirect::route('attachments.index')->with('message', 'Attachment deleted.');
	}
	
	/**
	 * Remove attachments.
	 */
	public function delete()
	{
		$data = Input::all();
		if (isset($data['ids'])) {
			foreach (Input::get('ids') as $id) {
				Attachment::destroy($id);
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('attachments.index')->with('message', 'Files deleted.');
			}
			else {
				return Redirect::back()->with('message', 'File deleted.');
			}
		}
		else return Redirect::back()->with('message_danger', 'You must select at least 1 file.');
	}
	
	/**
	 * Diable attachments.
	 */
	public function disable()
	{
		$data = Input::all();
		if (isset($data['ids'])) {
			foreach (Input::get('ids') as $id) {
				Attachment::find($id)->update(['disabled' => 1]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('attachments.index')->with('message', 'Files disabled.');
			}
			else {
				return Redirect::back()->with('message', 'File disabled.');
			}
		}
		else return Redirect::back()->with('message_danger', 'You must select at least 1 file.');
	}
	
	/**
	 * Enable attachments.
	 */
	public function enable()
	{
		$data = Input::all();
		if (isset($data['ids'])) {
			foreach (Input::get('ids') as $id) {
				Attachment::find($id)->update(['disabled' => 0]);	
			}
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('attachments.index')->with('message', 'Files enabled.');
			}
			else {
				return Redirect::back()->with('message', 'File enabled.');
			}
		}
		else return Redirect::back()->with('message_danger', 'You must select at least 1 file.');
	}

}