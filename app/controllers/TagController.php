<?php

class tagController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllTags(){
		$tags = Tag::all();
		foreach ($tags as $tag)
		{
			if (strtotime($tag['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$tag['new'] = 1;
			}
		}
		return $tags;
	}

	/**
	 * Display a listing of tags
	 *
	 * @return Response
	 */
	public function index()
	{
		$tags = Tag::all();

		return View::make('tag.index', compact('tags'));
	}

	/**
	 * Show the form for creating a new tag
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('tag.create');
	}

	/**
	 * Store a newly created tag in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Tag::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Tag::create($data);

		return Redirect::route('tags.index')->with('message', 'Tag created.');
	}

	/**
	 * Display the specified tag.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tag = Tag::findOrFail($id);

		return View::make('tag.show', compact('tag'));
	}

	/**
	 * Show the form for editing the specified tag.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tag = Tag::find($id);

		return View::make('tag.edit', compact('tag'));
	}

	/**
	 * Update the specified tag in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tag = Tag::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Tag::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$tag->update($data);

		return Redirect::route('tags.show', $id)->with('message', 'Tag updated.');
	}

	/**
	 * Remove the specified tag from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tag::destroy($id);
		return Redirect::route('tags.index')->with('message', 'Tag deleted.');
	}
	
	/**
	 * Remove tags.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Tag::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('tags.index')->with('message', 'Tags deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Tag deleted.');
		}
	}
	
	/**
	 * Diable tags.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Tag::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('tags.index')->with('message', 'Tags disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Tag disabled.');
		}
	}
	
	/**
	 * Enable tags.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Tag::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('tags.index')->with('message', 'Tags enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Tag enabled.');
		}
	}

}