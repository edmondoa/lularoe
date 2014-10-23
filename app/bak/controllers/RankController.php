<?php

class rankController extends \BaseController {

	// data only
	public function getAllRanks(){
		return Rank::all();
	}

	/**
	 * Display a listing of ranks
	 *
	 * @return Response
	 */
	public function index()
	{
		$ranks = Rank::all();

		return View::make('rank.index', compact('ranks'));
	}

	/**
	 * Show the form for creating a new rank
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('rank.create');
	}

	/**
	 * Store a newly created rank in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Rank::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Rank::create($data);

		return Redirect::route('rank.index')->with('message', 'Rank created.');
	}

	/**
	 * Display the specified rank.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$rank = Rank::findOrFail($id);

		return View::make('rank.show', compact('rank'));
	}

	/**
	 * Show the form for editing the specified rank.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rank = Rank::find($id);

		return View::make('rank.edit', compact('rank'));
	}

	/**
	 * Update the specified rank in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rank = Rank::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Rank::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$rank->update($data);

		return Redirect::route('ranks.show')->with('message', 'Rank updated.');
	}

	/**
	 * Remove the specified rank from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Rank::destroy($id);

		return Redirect::route('rank.index')->with('message', 'Rank deleted.');
	}
	
	/**
	 * Remove ranks.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Rank::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('rank.index')->with('message', 'Ranks deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Rank deleted.');
		}
	}
	
	/**
	 * Diable ranks.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Rank::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('rank.index')->with('message', 'Ranks disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Rank disabled.');
		}
	}
	
	/**
	 * Enable ranks.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Rank::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('rank.index')->with('message', 'Ranks enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Rank enabled.');
		}
	}

}