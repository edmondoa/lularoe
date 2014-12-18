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
	 * Store a newly created attachment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Attachment::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Attachment::create($data);

		return Redirect::route('attachments.index')->with('message', 'Attachment created.');
	}

	/**
	 * Upload attachment
	 */
	 
	public function upload() {
		// echo '<pre>'; print_r(Input::all()); echo '</pre>';
		// echo '<pre>'; print_r($_POST); echo '</pre>';
		// exit;
		$response = [];
		$validator = Validator::make($data = Input::all(), Attachment::$rules);
		if ($validator->fails())
		{
			$response['success'] = false;
			$response['errors'] = json_encode($validator->messages());
			return $response;
		}
		
		// process and store image
        if (Input::file('image')) {

            // upload and link to image
            $filename = '';
            if (Input::hasFile('image')) {
                $file = Input::file('image');
				
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
						
                // open an image file
				$img = Image::make('uploads/' . $path . $filename);
    
                // now you are able to resize the instance
                $img->fit(800, 600);

                // finally we save the image as a new image
                $img->save('uploads/' . $path . $filename);

				// store record in database
                $data['url'] = $url;
				$data['type'] = 'Image';
				$data['user_id'] = Auth::user()->id;
				$attachment = Attachment::create($data);
				$response['success'] = true;
				$response['url'] = '/uploads/' . $attachment->url;
				return $response;

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
		foreach (Input::get('ids') as $id) {
			Attachment::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('attachments.index')->with('message', 'Attachments deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Attachment deleted.');
		}
	}
	
	/**
	 * Diable attachments.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Attachment::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('attachments.index')->with('message', 'Attachments disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Attachment disabled.');
		}
	}
	
	/**
	 * Enable attachments.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Attachment::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('attachments.index')->with('message', 'Attachments enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Attachment enabled.');
		}
	}

}