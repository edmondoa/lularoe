<?php

class levelController extends \BaseController {

	// data only
	public function getAllLevels(){
		return Level::all();
	}

	/**
	 * Display a listing of levels
	 *
	 * @return Response
	 */
	public function index()
	{
		$levels = Level::all();

		return View::make('level.index', compact('levels'));
	}

	/**
	 * Show the form for creating a new level
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('level.create');
	}

	/**
	 * Store a newly created level in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Level::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Level::create($data);

		return Redirect::route('level.index')->with('message', 'Level created.');
	}

	/**
	 * Display the specified level.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$level = Level::findOrFail($id);

		return View::make('level.show', compact('level'));
	}

	/**
	 * Show the form for editing the specified level.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$level = Level::find($id);

		return View::make('level.edit', compact('level'));
	}

	/**
	 * Update the specified level in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$level = Level::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Level::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$level->update($data);

		return Redirect::route('levels.show')->with('message', 'Level updated.');
	}

	/**
	 * Remove the specified level from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Level::destroy($id);

		return Redirect::route('level.index')->with('message', 'Level deleted.');
	}
	
	/**
	 * Remove levels.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Level::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('level.index')->with('message', 'Levels deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Level deleted.');
		}
	}
	
	/**
	 * Diable levels.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Level::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('level.index')->with('message', 'Levels disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Level disabled.');
		}
	}
	
	/**
	 * Enable levels.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Level::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('level.index')->with('message', 'Levels enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Level enabled.');
		}
	}

}