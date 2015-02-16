<?php

class ProfileController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllProfiles(){
		$profiles = Profile::all();
		foreach ($profiles as $profile)
		{
			if (strtotime($profile['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$profile['new'] = 1;
			}
		}
		return $profiles;
	}

	/**
	 * Display a listing of profiles
	 *
	 * @return Response
	 */
	public function index()
	{
		$profiles = Profile::all();

		return View::make('profile.index', compact('profiles'));
	}

	/**
	 * Show the form for creating a new profile
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('profile.create');
	}

	/**
	 * Store a newly created profile in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Profile::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Profile::create($data);

		return Redirect::route('profiles.index')->with('message', 'Profile created.');
	}

	/**
	 * Display the specified profile.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$profile = Profile::findOrFail($id);

		return View::make('profile.show', compact('profile'));
	}

	/**
	 * Show the form for editing the specified profile.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$profile = Profile::find($id);

		return View::make('profile.edit', compact('profile'));
	}

	/**
	 * Update the specified profile in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$profile = Profile::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Profile::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$profile->update($data);

		return Redirect::route('profiles.show', $id)->with('message', 'Profile updated.');
	}

	/**
	 * Remove the specified profile from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Profile::destroy($id);

		return Redirect::route('profiles.index')->with('message', 'Profile deleted.');
	}
	
	/**
	 * Remove profiles.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			Profile::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('profiles.index')->with('message', 'Profiles deleted.');
		}
		else {
			return Redirect::back()->with('message', 'Profile deleted.');
		}
	}
	
	/**
	 * Diable profiles.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			Profile::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('profiles.index')->with('message', 'Profiles disabled.');
		}
		else {
			return Redirect::back()->with('message', 'Profile disabled.');
		}
	}
	
	/**
	 * Enable profiles.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			Profile::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('profiles.index')->with('message', 'Profiles enabled.');
		}
		else {
			return Redirect::back()->with('message', 'Profile enabled.');
		}
	}

}