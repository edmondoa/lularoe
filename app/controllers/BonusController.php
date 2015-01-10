<?php

class bonusController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllBonuses(){
		$bonuses = Bonus::all();
		foreach ($bonuses as $bonus)
		{
			if (strtotime($bonus['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$bonus['new'] = 1;
			}
		}
		return $bonuses;
	}

	/**
	 * Display a listing of bonuses
	 *
	 * @return Response
	 */
	public function index()
	{
		$bonuses = Bonus::all();

		return View::make('bonus.index', compact('bonuses'));
	}

	/**
	 * Show the form for creating a new bonus
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('bonus.create');
	}

	/**
	 * Store a newly created bonus in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Bonus::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Bonus::create($data);

		return Redirect::route('bonuses.index')->with('message', 'Bonus created.');
	}

	/**
	 * Display the specified bonus.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bonus = Bonus::findOrFail($id);

		return View::make('bonus.show', compact('bonus'));
	}

	/**
	 * Show the form for editing the specified bonus.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bonus = Bonus::find($id);

		return View::make('bonus.edit', compact('bonus'));
	}

	/**
	 * Update the specified bonus in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$bonus = Bonus::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Bonus::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bonus->update($data);

		return Redirect::route('bonuses.show', $id)->with('message', 'Bonus updated.');
	}

	/**
	 * Remove the specified bonus from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Bonus::destroy($id);

		return Redirect::route('bonuses.index')->with('message', 'Bonus deleted.');
	}
	
	/**
	 * Remove bonuses.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Bonus::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('bonuses.index')->with('message', 'Bonuses deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Bonus deleted.');
		}
	}
	
	/**
	 * Diable bonuses.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Bonus::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('bonuses.index')->with('message', 'Bonuses disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Bonus disabled.');
		}
	}
	
	/**
	 * Enable bonuses.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Bonus::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('bonuses.index')->with('message', 'Bonuses enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Bonus enabled.');
		}
	}

}