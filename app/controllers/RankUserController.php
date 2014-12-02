<?php

class rankUserController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllrankUsers(){
		$rankUsers = rankUser::all();
		foreach ($rankUsers as $rankUser)
		{
			if (strtotime($rankUser['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$rankUser['new'] = 1;
			}
		}
		return $rankUsers;
	}

	/**
	 * Display a listing of rankUsers
	 *
	 * @return Response
	 */
	public function index()
	{
		$rankUsers = rankUser::all();

		return View::make('rankUser.index', compact('rankUsers'));
	}

	/**
	 * Show the form for creating a new rankUser
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('rankUser.create');
	}

	/**
	 * Store a newly created rankUser in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), rankUser::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		rankUser::create($data);

		return Redirect::route('rankUsers.index')->with('message', 'rankUser created.');
	}

	/**
	 * Display the specified rankUser.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$rankUser = rankUser::findOrFail($id);

		return View::make('rankUser.show', compact('rankUser'));
	}

	/**
	 * Show the form for editing the specified rankUser.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rankUser = rankUser::find($id);

		return View::make('rankUser.edit', compact('rankUser'));
	}

	/**
	 * Update the specified rankUser in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rankUser = rankUser::findOrFail($id);

		$validator = Validator::make($data = Input::all(), rankUser::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$rankUser->update($data);

		return Redirect::route('rankUsers.show', $id)->with('message', 'rankUser updated.');
	}

	/**
	 * Remove the specified rankUser from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		rankUser::destroy($id);

		return Redirect::route('rankUsers.index')->with('message', 'rankUser deleted.');
	}
	
	/**
	 * Remove rankUsers.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			rankUser::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('rankUsers.index')->with('message', 'rankUsers deleted.');
		}
		else {
			return Redirect::back()->with('message', 'rankUser deleted.');
		}
	}
	
	/**
	 * Diable rankUsers.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			rankUser::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('rankUsers.index')->with('message', 'rankUsers disabled.');
		}
		else {
			return Redirect::back()->with('message', 'rankUser disabled.');
		}
	}
	
	/**
	 * Enable rankUsers.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			rankUser::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('rankUsers.index')->with('message', 'rankUsers enabled.');
		}
		else {
			return Redirect::back()->with('message', 'rankUser enabled.');
		}
	}

}