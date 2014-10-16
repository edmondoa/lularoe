<?php

class userRankController extends \BaseController {

	// data only
	public function getAllUserRanks(){
		return UserRank::all();
	}

	/**
	 * Display a listing of userRanks
	 *
	 * @return Response
	 */
	public function index()
	{
		$userRanks = UserRank::all();

		return View::make('userRank.index', compact('userRanks'));
	}

	/**
	 * Show the form for creating a new userRank
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('userRank.create');
	}

	/**
	 * Store a newly created userRank in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), UserRank::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		UserRank::create($data);

		return Redirect::route('userRank.index')->with('message', 'UserRank created.');
	}

	/**
	 * Display the specified userRank.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$userRank = UserRank::findOrFail($id);

		return View::make('userRank.show', compact('userRank'));
	}

	/**
	 * Show the form for editing the specified userRank.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$userRank = UserRank::find($id);

		return View::make('userRank.edit', compact('userRank'));
	}

	/**
	 * Update the specified userRank in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$userRank = UserRank::findOrFail($id);

		$validator = Validator::make($data = Input::all(), UserRank::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$userRank->update($data);

		return Redirect::route('userRanks.show')->with('message', 'UserRank updated.');
	}

	/**
	 * Remove the specified userRank from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		UserRank::destroy($id);

		return Redirect::route('userRank.index')->with('message', 'UserRank deleted.');
	}
	
	/**
	 * Remove userRanks.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			UserRank::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'UserRanks deleted.');
		}
		else {
			return Redirect::back()->with('message', 'UserRank deleted.');
		}
	}
	
	/**
	 * Diable userRanks.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			UserRank::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'UserRanks disabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserRank disabled.');
		}
	}
	
	/**
	 * Enable userRanks.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			UserRank::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('product.index')->with('message', 'UserRanks enabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserRank enabled.');
		}
	}

}