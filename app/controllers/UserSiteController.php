<?php

class userSiteController extends \BaseController {

	/**
	 * Data only
	 */
	public function getAllUserSites(){
		$userSites = UserSite::all();
		foreach ($userSites as $userSite)
		{
			if (strtotime($userSite['created_at']) >= (time() - Config::get('site.new_time_frame') ))
			{
				$userSite['new'] = 1;
			}
		}
		return $userSites;
	}

	/**
	 * Display a listing of userSites
	 *
	 * @return Response
	 */
	public function index()
	{
		$userSites = UserSite::all();

		return View::make('userSite.index', compact('userSites'));
	}

	/**
	 * Show the form for creating a new userSite
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('userSite.create');
	}

	/**
	 * Store a newly created userSite in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), UserSite::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		UserSite::create($data);

		return Redirect::route('userSite.index')->with('message', 'Site created.');
	}

	public function show($public_id)
	{
		$user = User::where('public_id', $public_id)->first();
		$userSite = UserSite::where('user_id', $user->id)->first();
		$user = User::find($userSite['user_id']);
		return View::make('userSite.show', compact('user', 'userSite'));
	}

	/**
	 * Show the form for editing the specified userSite.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$userSite = UserSite::where('user_id', $id)->first();
		return View::make('userSite.edit', compact('userSite'));
	}

	/**
	 * Update the specified userSite in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$userSite = UserSite::findOrFail($id);
		$user = User::where('id', $userSite->user_id)->first();
		$validator = Validator::make($data = Input::all(), UserSite::$rules);



		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        if (Input::file('image')) {
            // upload and link to image
            $filename = '';
            if (Input::hasFile('image')) {
                $file = Input::file('image');
                $destinationPath = public_path() . '/img/users/';
                $extension = $file->getClientOriginalExtension();
                $filename = str_random(20) . '.' . $extension;
                $uploadSuccess   = $file->move($destinationPath, $filename);
    
                // open an image file
                $img = Image::make('img/users/' . $filename);
    
                // now you are able to resize the instance
                $img->fit(100, 100);
    
                // finally we save the image as a new image
                $img->save('img/users/' . $filename);
    
                $data['image'] = $filename;
				DB::update('update users set image = "' . $data['image'] . '" where id = ' . $user->id);
            }
        }
		$userSite->update($data);

		return Redirect::back()->with('message', 'Site updated.');
	}

	/**
	 * Remove the specified userSite from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		UserSite::destroy($id);

		return Redirect::route('userSite.index')->with('message', 'Site deleted.');
	}
	
	/**
	 * Remove userSites.
	 */
	public function delete()
	{
		foreach (Input::get('ids') as $id) {
			UserSite::destroy($id);
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('userSite.index')->with('message', 'Sites deleted.');
		}
		else {
			return Redirect::back()->with('message', 'UserSite deleted.');
		}
	}
	
	/**
	 * Diable userSites.
	 */
	public function disable()
	{
		foreach (Input::get('ids') as $id) {
			UserSite::find($id)->update(['disabled' => 1]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('userSite.index')->with('message', 'Sites disabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserSite disabled.');
		}
	}
	
	/**
	 * Enable userSites.
	 */
	public function enable()
	{
		foreach (Input::get('ids') as $id) {
			UserSite::find($id)->update(['disabled' => 0]);	
		}
		if (count(Input::get('ids')) > 1) {
			return Redirect::route('userSite.index')->with('message', 'Sites enabled.');
		}
		else {
			return Redirect::back()->with('message', 'UserSite enabled.');
		}
	}

}