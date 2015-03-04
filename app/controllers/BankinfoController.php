<?php

class BankinfoController extends \BaseController {

	/**
	 * Display a listing of bankinfo
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->hasRole(['Superadmin', 'Admin'])) {
			$bankinfo = Bankinfo::all();
			return View::make('bankinfo.index', compact('bankinfo'));
		}
	}

	/**
	 * Show the form for creating a new bankinfo
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('bankinfo.create');
	}

	/**
	 * Store a newly created bankinfo in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Bankinfo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		// Do I really have to do this?
		$data['user_id'] = Auth::user()->id;

		Bankinfo::create($data);
		if (Auth::user()->hasRole(['Rep'])) return Redirect::route('settings');
		else return Redirect::back()->with('message', 'Bankinfo created.');
	}

	/**
	 * Display the specified bankinfo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bankinfo = Bankinfo::findOrFail($id);
		if (Auth::user()->hasRole(['Superadmin', 'Admin']) || $bankinfo->user_id == Auth::user()->id) {
			return View::make('bankinfo.show', compact('bankinfo'));
		}
	}

	/**
	 * Show the form for editing the specified bankinfo.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bankinfo = Bankinfo::find($id);
		if (Auth::user()->hasRole(['Superadmin', 'Admin']) || $bankinfo->user_id == Auth::user()->id) {
			return View::make('bankinfo.edit', compact('bankinfo'));
		}
	}

	/**
	 * Update the specified bankinfo in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$bankinfo = Bankinfo::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Bankinfo::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bankinfo->update($data);

		return Redirect::to(Session::get('previous_page_2'))->with('message', 'Bankinfo updated.');
	}

	/**
	 * Remove the specified bankinfo from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$bankinfo = Bankinfo::find($id);
		if (Auth::user()->hasRole(['Superadmin', 'Admin']) || $bankinfo->user_id = Auth::user()->id) {
			Bankinfo::destroy($id);
			if (Auth::user()->hasRole(['Rep'])) return Redirect::route('settings')->with('message', 'Bankinfo deleted.');
			else return Redirect::route('bankinfo.index')->with('message', 'Bankinfo deleted.');
		}
	}
	
	/**
	 * Remove bankinfo.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Bankinfo::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('bankinfo.index')->with('message', 'Bankinfo deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Bankinfo deleted.');
		}
	}
	
	/**
	 * Diable bankinfo.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Bankinfo::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('bankinfo.index')->with('message', 'Bankinfo disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Bankinfo disabled.');
		}
	}
	
	/**
	 * Enable bankinfo.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Bankinfo::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('bankinfo.index')->with('message', 'Bankinfo enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Bankinfo enabled.');
		}
	}

}