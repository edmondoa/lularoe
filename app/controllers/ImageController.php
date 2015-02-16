<?php

class ImageController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllImages(){
		$images = Image::all();
		foreach ($images as $image)
		{
			if (strtotime($image['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$image['new'] = 1;
			}
		}
		return $images;
	}

	/**
	 * Display a listing of images
	 *
	 * @return Response
	 */
	public function index()
	{
		$images = Image::all();

		return View::make('image.index', compact('images'));
	}

	/**
	 * Show the form for creating a new image
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('image.create');
	}

	/**
	 * Store a newly created image in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Image::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Image::create($data);

		return Redirect::route('images.index')->with('message', 'Image created.');
	}

	/**
	 * Display the specified image.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$image = Image::findOrFail($id);

		return View::make('image.show', compact('image'));
	}

	/**
	 * Show the form for editing the specified image.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$image = Image::find($id);

		return View::make('image.edit', compact('image'));
	}

	/**
	 * Update the specified image in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$image = Image::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Image::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$image->update($data);

		return Redirect::route('images.show', $id)->with('message', 'Image updated.');
	}

	/**
	 * Remove the specified image from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Image::destroy($id);

		return Redirect::route('images.index')->with('message', 'Image deleted.');
	}
	
	/**
	 * Remove images.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Image::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('images.index')->with('message', 'Images deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Image deleted.');
		}
	}
	
	/**
	 * Diable images.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Image::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('images.index')->with('message', 'Images disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Image disabled.');
		}
	}
	
	/**
	 * Enable images.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Image::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('images.index')->with('message', 'Images enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Image enabled.');
		}
	}

}