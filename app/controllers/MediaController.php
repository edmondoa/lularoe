<?php

class mediaController extends \BaseController {

	/**
	 * Display a listing of media
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('media.index', compact('media'));
	}
	
	/**
	 * Display a listing of media belonging to a user
	 *
	 * @return Response
	 */
	public function user($id)
	{
		$user_id = $id;
		return View::make('media.index', compact('media', 'user_id'));
	}
	
	/**
	 * Display a listing of media belonging to all reps
	 *
	 * @return Response
	 */
	public function reps()
	{
		$reps = true;
		return View::make('media.index', compact('media', 'reps'));
	}

	/**
	 * Show the form for creating a new media
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('media.create');
	}

	/**
	 * Upload media
	 */
	 
	public function store() {

		// validation
		$rules = [
			'media' => 'required|max:5000',
		];
		$validator = Validator::make($data = Input::all(), $rules);
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
		
		include app_path() . '/helpers/processMedia.php';
				
		// format checkboxes for db
		$data['reps'] = isset($data['reps']) ? 1 : 0;

		// store in db and redirect
		$media = Media::create($data);
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllMedia')));
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getMediaByUser')));
		if (isset($data['ajax'])) {
			$response['success'] = true;
			$response['url'] = '/uploads/' . $media->url;
			return $response;
		}
		else {
			if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) $user_id = 0;
			else $user_id = Auth::user()->id;
			return Redirect::route('media/user', compact('user_id'))->with('message', 'File updated.');
		}

	}

	/**
	 * Display the specified media.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$media = Media::findOrFail($id);

		return View::make('media.show', compact('media'));
	}

	/**
	 * Show the form for editing the specified media.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$media = Media::find($id);

		return View::make('media.edit', compact('media'));
	}

	/**
	 * Update the specified media in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$media = Media::findOrFail($id);

		// validation
		$rules = [
			'media' => 'sometimes|max:5000',
		];
		$validator = Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		// format checkboxes for db
		$data['reps'] = isset($data['reps']) ? 1 : 0;

		include app_path() . '/helpers/processMedia.php';

		// if file exists, delete it
		$old_file = $media->url;
		if (is_file('/uploads/' . $old_file)) {
			unlink('/uploads/' . $old_file);
		}

		// update db
		if ($data['media'] == '') $data['url'] = $media->url;
		$media->update($data);
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllMedia')));
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getMediaByUser')));
		if (Auth::user()->hasRole(['Superadmin', 'Admin', 'Editor'])) $user_id = 0;
		else $user_id = Auth::user()->id;
		return Redirect::route('media/user', compact('user_id'))->with('message', 'File updated.');
	}

	/**
	 * Remove the specified media from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Media::destroy($id);
		Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllMedia')));
		return Redirect::route('media.index')->with('message', 'File deleted.');
	}
	
	/**
	 * Remove media.
	 */
	public function delete()
	{
		$data = Input::all();
		if (isset($data['ids'])) {
			foreach (Input::get('ids') as $id) {
				// delete media
				$media = Media::find($id);
				unlink('/uploads/' . $media->image);
				unlink('/uploads/' . $media->image_sm);
				Media::destroy($id);
			}
			Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllMedia')));
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('media.index')->with('message', 'Files deleted.');
			}
			else {
				return Redirect::back()->with('message', 'File deleted.');
			}
		}
		else return Redirect::back()->with('message_danger', 'You must select at least 1 file.');
	}
	
	/**
	 * Diable media.
	 */
	public function disable()
	{
		$data = Input::all();
		if (isset($data['ids'])) {
			foreach (Input::get('ids') as $id) {
				Media::find($id)->update(['disabled' => 1]);	
			}
			Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllMedia')));
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('media.index')->with('message', 'File disabled.');
			}
			else {
				return Redirect::back()->with('message', 'File disabled.');
			}
		}
		else return Redirect::back()->with('message_danger', 'You must select at least 1 file.');
	}
	
	/**
	 * Enable media.
	 */
	public function enable()
	{
		$data = Input::all();
		if (isset($data['ids'])) {
			foreach (Input::get('ids') as $id) {
				Media::find($id)->update(['disabled' => 0]);	
			}
			Cache::forget('route_'.Str::slug(action('DataOnlyController@getAllMedia')));
			if (count(Input::get('ids')) > 1) {
				return Redirect::route('media.index')->with('message', 'File enabled.');
			}
			else {
				return Redirect::back()->with('message', 'File enabled.');
			}
		}
		else return Redirect::back()->with('message_danger', 'You must select at least 1 file.');
	}

}